# Foro

Creación de un website tipo "foro" inspirado en el funcionamiento de StackOverflow.

---

## Metodología

- **Trabajo en parejas**  
- **Temporalización**: Aproximadamente 8-10 horas de desarrollo  

---

## Funcionamiento

El objetivo es desarrollar una versión inicial de un foro con las siguientes características:  
- Registro e inicio de sesión de usuarios.  
- Publicación de preguntas y respuestas.  
- Búsqueda de preguntas y usuarios.  
- Interacciones opcionales entre usuarios (amistades y chat privado).

---

### Inicio de sesión y registro de usuario

- **Pantalla inicial**: Permite registrarse o iniciar sesión.
- **Registro**: Requiere los siguientes campos:
- Nombre de usuario
- Nombre real
- Email
- Contraseña

---

### Funcionalidades para usuarios registrados

#### 1. Publicación y gestión de preguntas  
- Los usuarios pueden crear preguntas mediante un formulario con los siguientes campos:  
- Título  
- Descripción  
- Etiquetas (ej., PHP, HTML, MySQL)  
- Cada usuario puede:
- Ver un listado de sus preguntas publicadas.  
- Editar o eliminar solo sus propias preguntas.  

#### 2. Respuestas a preguntas  
- Los usuarios pueden responder preguntas mediante un formulario con un límite de **500 caracteres**.  
- Las respuestas se mostrarán **ordenadas de más reciente a más antigua**.  
- Cada respuesta incluirá:
- Nombre del usuario que la publicó.  
- Fecha de publicación.  

#### 3. Búsqueda de preguntas y usuarios  
- **Búsqueda de preguntas**: Los usuarios pueden buscar preguntas por título.  
- **Búsqueda de usuarios**: Permite buscar otros usuarios por:
- Nombre de usuario  
- Nombre real  
- Al buscar un usuario, se mostrará una lista de coincidencias.

#### 4. Interacciones con otros usuarios (opcional)  
- En el perfil de un usuario, se puede:  
- Enviar una solicitud de amistad.  
- Si la amistad es aceptada, se habilitará un **chat privado** para intercambiar mensajes.

---

## Aspectos a valorar

### 1. Configuración de la base de datos  
- La base de datos debe permitir todas las funcionalidades descritas.  
- Tablas bien estructuradas para:
- Usuarios  
- Preguntas  
- Respuestas  
- (Opcional) Amistades y mensajes.  

### 2. Validación y saneamiento de datos  
- Todos los formularios deben incluir validación y saneamiento de datos para:
- Prevenir inyecciones de código.  
- Garantizar datos válidos mediante **PHP** y **JavaScript**.  

### 3. Protección contra ataques SQL  
- Las consultas deben prevenir inyecciones SQL.  

### 4. Encriptación de contraseñas  
- Uso de **BCRYPT** para almacenar las contraseñas de forma segura.  

### 5. Uso de GIT con ramas  
- Se valorará el manejo del repositorio con:
- Ramas separadas para desarrollo.  
- Commits descriptivos.  

---

## Detalles adicionales en la presentación del foro

- **Preguntas**:
- Mostrar la fecha de publicación.  
- Indicar el usuario que la publicó.  
- Incluir las etiquetas asociadas.  
- **Respuestas**:
- Mostrar el nombre del usuario que la escribió.  
- Indicar la fecha de publicación.
