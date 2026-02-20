# Moodle Plugin: Descarga Masiva de Certificados (local_descargacertificados)

## 📖 Descripción General

Este es un plugin local para Moodle que proporciona una herramienta administrativa para buscar usuarios (por *Username* o *Email*) y descargar de manera automática un archivo `.zip` con todos sus certificados emitidos en formato PDF.
El sistema filtra y descarga exclusivamente los certificados cuyas plantillas comiencen con el prefijo **"Free"**.

## ⚙️ Requisitos Técnicos

* **Versión de Moodle:** 4.1 o superior.
* **Dependencia estricta:** Requiere tener instalado y activo el plugin **Certificado Personalizado (`tool_certificate`)**.
* **Versión de PHP:** 8.0 o superior.

## 🗂️ Estructura de Archivos

El plugin sigue la estructura estándar de Moodle para el tipo `local`:

local/descargacertificados/
├── classes/
│   └── form/
│       └── search_form.php       (Formulario de búsqueda)
├── db/
│   └── access.php                (Definición de permisos personalizados)
├── lang/
│   ├── en/
│   │   └── local_descargacertificados.php
│   └── es/
│       └── local_descargacertificados.php
├── index.php                     (Lógica principal de búsqueda y generación de ZIP)
├── settings.php                  (Configuración del menú de Moodle)
└── version.php                   (Control de versión)

## 🔒 Seguridad y Permisos

Para evitar descargas no autorizadas, este plugin utiliza un permiso (*capability*) propio.

* **Permiso:** `local/descargacertificados:download`
* **Acceso por defecto:** Los roles de Administrador/Gestor (`manager`) tienen acceso automático.
* **Configuración para otros roles:** Para permitir que otros roles (ej. Coordinador o Profesor) utilicen esta herramienta, un administrador debe ir a *Administración del sitio > Usuarios > Permisos > Definir roles*, buscar el permiso **"Descargar certificados de usuarios masivamente"** y marcar la casilla de "Permitir".

## 🚀 Instalación

1. Empaqueta el contenido de este repositorio en un archivo `.zip`.
2. Sube y extrae la carpeta en el directorio `/local/` de tu servidor Moodle. Asegúrate de que la carpeta se llame exactamente `descargacertificados`.
3. Ingresa a Moodle como Administrador.
4. Ve a **Administración del sitio > Notificaciones**.
5. Haz clic en el botón **"Actualizar base de datos Moodle ahora"** para instalar el plugin y registrar los nuevos permisos.

## 🛠️ Uso del Plugin.

1. En tu panel de Moodle, navega a **Administración del sitio > Informes > Descarga Masiva de Certificados**.
2. Ingresa el **Nombre de usuario (Username)** o el **Correo electrónico (Email)** del alumno.
3. Haz clic en **Buscar y Descargar Todos**.
4. El sistema verificará la base de datos y compilará los archivos PDF físicos en un archivo `.zip` que se descargará automáticamente a tu navegador.
