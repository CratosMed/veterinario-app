const { app, BrowserWindow } = require('electron')
const path = require('path')

function createWindow() {
  const win = new BrowserWindow({
    width: 800,
    height: 600,
    webPreferences: {
      //preload: path.join(__dirname, 'preload.js'), // Si usas un preload script
      contextIsolation: true,
      enableRemoteModule: false,
      nodeIntegration: false, // Asegúrate de que esto esté desactivado por razones de seguridad
    }
  })

  // Cambiar para cargar el archivo index.html desde la carpeta de distribución
  win.loadFile(path.join(__dirname, 'dist', 'index.html'))
}

app.whenReady().then(createWindow)

app.on('window-all-closed', () => {
  if (process.platform !== 'darwin') {
    app.quit()
  }
})

app.on('activate', () => {
  if (BrowserWindow.getAllWindows().length === 0) {
    createWindow()
  }
})
