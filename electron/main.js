const { app, BrowserWindow, Menu, Tray, dialog } = require('electron');
const path = require('path');
const net = require('net');
const fs = require('fs');
const { spawn } = require('child_process');

let mainWindow = null;
let tray = null;
let phpProcess = null;

const PORT = 8095;
const APP_URL = `http://127.0.0.1:${PORT}`;
const ROOT_DIR = path.resolve(__dirname, '..');
const APP_ICON = path.join(ROOT_DIR, 'public', 'img', 'logo.ico');

// 1. COMPROBAR SI UN PUERTO ESTÁ ESCUCHANDO
function checkPort(port, host = '127.0.0.1') {
  return new Promise((resolve) => {
    const socket = new net.Socket();
    socket.setTimeout(400);
    socket.on('connect', () => {
      socket.destroy();
      resolve(true);
    });
    socket.on('timeout', () => {
      socket.destroy();
      resolve(false);
    });
    socket.on('error', () => {
      resolve(false);
    });
    socket.connect(port, host);
  });
}

// 2. DETECTAR EL EJECUTABLE DE PHP (PORTABLE O SISTEMA)
function obtenerRutaPhp() {
  const posiblesRutas = [
    path.join(ROOT_DIR, 'php', 'php.exe'),
    'C:\\xampp\\php\\php.exe',
    'php'
  ];

  for (const ruta of posiblesRutas) {
    if (ruta === 'php' || fs.existsSync(ruta)) {
      return ruta;
    }
  }
  return 'php';
}

// 3. INICIAR SERVIDOR PHP INTERNO (CERO DEPENDENCIAS DE APACHE / MYSQL)
async function iniciarServidorInterno() {
  const activo = await checkPort(PORT);
  if (activo) {
    console.log(`Servidor interno ya escuchando en puerto ${PORT}.`);
    return;
  }

  const phpExe = obtenerRutaPhp();
  console.log(`Iniciando servidor PHP interno embebido con: ${phpExe}`);

  try {
    phpProcess = spawn(phpExe, ['-S', `127.0.0.1:${PORT}`, '-t', ROOT_DIR], {
      cwd: ROOT_DIR,
      detached: false,
      stdio: 'ignore',
      windowsHide: true
    });

    phpProcess.on('error', (err) => {
      console.error('Error al iniciar el proceso PHP:', err);
      dialog.showErrorBox(
        'Error de Ejecución',
        'No se pudo iniciar el motor PHP embebido. Asegúrese de que PHP esté disponible.'
      );
    });
  } catch (err) {
    console.error('Fallo al ejecutar PHP:', err);
  }

  // Esperar a que el puerto responda
  for (let i = 0; i < 20; i++) {
    const ok = await checkPort(PORT);
    if (ok) {
      console.log(`Servidor PHP listo en puerto ${PORT} tras ${(i + 1) * 200}ms.`);
      break;
    }
    await new Promise((r) => setTimeout(r, 200));
  }
}

// 4. CREAR VENTANA PRINCIPAL DE ESCRITORIO
function crearVentanaPrincipal() {
  mainWindow = new BrowserWindow({
    width: 1280,
    height: 840,
    minWidth: 1024,
    minHeight: 700,
    title: 'Tópico Médico Institucional - Sistema Autónomo',
    icon: fs.existsSync(APP_ICON) ? APP_ICON : undefined,
    autoHideMenuBar: true,
    show: false,
    backgroundColor: '#f8fafc',
    webPreferences: {
      nodeIntegration: false,
      contextIsolation: true
    }
  });

  mainWindow.setMenuBarVisibility(false);
  cargarUrlConReintentos(APP_URL, 10);

  mainWindow.once('ready-to-show', () => {
    mainWindow.maximize();
    mainWindow.show();
  });

  mainWindow.on('closed', () => {
    mainWindow = null;
  });
}

function cargarUrlConReintentos(url, reintentosRestantes) {
  if (!mainWindow) return;

  mainWindow.loadURL(url).catch(async () => {
    if (reintentosRestantes > 0) {
      await new Promise((r) => setTimeout(r, 600));
      cargarUrlConReintentos(url, reintentosRestantes - 1);
    } else {
      dialog.showErrorBox(
        'Error de Conexión',
        `No se pudo conectar a la aplicación en ${APP_URL}`
      );
    }
  });
}

// 5. BANDEJA DEL SISTEMA (TRAY)
function configurarBandeja() {
  if (!fs.existsSync(APP_ICON)) return;

  try {
    tray = new Tray(APP_ICON);
    const contextMenu = Menu.buildFromTemplate([
      {
        label: '🏥 Abrir Tópico Médico',
        click: () => {
          if (mainWindow) {
            mainWindow.show();
            mainWindow.focus();
          } else {
            crearVentanaPrincipal();
          }
        }
      },
      {
        label: '🔄 Recargar Pantalla',
        click: () => {
          if (mainWindow) mainWindow.reload();
        }
      },
      { type: 'separator' },
      {
        label: '❌ Salir',
        click: () => {
          app.isQuiting = true;
          app.quit();
        }
      }
    ]);

    tray.setToolTip('Tópico Médico Institucional (SQLite Integrado)');
    tray.setContextMenu(contextMenu);
    tray.on('double-click', () => {
      if (mainWindow) {
        mainWindow.show();
        mainWindow.focus();
      }
    });
  } catch (e) {
    console.warn('Tray no inicializado:', e);
  }
}

// 6. CONTROL DE CICLO DE VIDA (INSTANCIA ÚNICA)
const singleInstanceLock = app.requestSingleInstanceLock();
if (!singleInstanceLock) {
  app.quit();
} else {
  app.on('second-instance', () => {
    if (mainWindow) {
      if (mainWindow.isMinimized()) mainWindow.restore();
      mainWindow.focus();
    }
  });

  app.whenReady().then(async () => {
    await iniciarServidorInterno();
    crearVentanaPrincipal();
    configurarBandeja();

    app.on('activate', () => {
      if (BrowserWindow.getAllWindows().length === 0) crearVentanaPrincipal();
    });
  });

  app.on('will-quit', () => {
    if (phpProcess) {
      try {
        phpProcess.kill();
      } catch (e) {}
    }
  });

  app.on('window-all-closed', () => {
    if (process.platform !== 'darwin') {
      app.quit();
    }
  });
}
