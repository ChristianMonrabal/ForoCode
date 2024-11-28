CREATE DATABASE forocode;
USE forocode;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    nombre_real VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    etiquetas VARCHAR(255),
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_id INT NOT NULL,
    usuario_id INT NOT NULL,
    contenido TEXT NOT NULL,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

INSERT INTO Usuarios (username, nombre_real, email, password) VALUES 
('admin', 'Administrador', 'admin@forocode.com', '$2y$10$BHurAxvbcvVDNiatSBjzK.YjiVQYs1l339TOFgIukmTheaXG9xRxS'),
('Christianmd', 'Christian Monrabal', 'christian@gmail.com', '$2y$10$BHurAxvbcvVDNiatSBjzK.YjiVQYs1l339TOFgIukmTheaXG9xRxS');


INSERT INTO preguntas (usuario_id, titulo, descripcion, etiquetas) VALUES
(2, '¿Cómo crear una base de datos en MySQL?', 'Estoy intentando crear una base de datos en MySQL pero no sé por dónde empezar. ¿Alguien me puede ayudar?', 'mysql, base de datos, tutorial'),
(2, '¿Qué es el JOIN en SQL?', 'Tengo dudas sobre cómo funciona el JOIN en SQL. ¿Cuáles son los tipos y cuándo usar cada uno?', 'sql, join, bases de datos'),
(2, '¿Cómo mejorar el rendimiento de una aplicación PHP?', 'Tengo una aplicación en PHP que está funcionando, pero quiero mejorar su rendimiento. ¿Qué prácticas debo seguir?', 'php, rendimiento, optimización'),
(2, '¿Qué es una API RESTful?', 'Estoy aprendiendo sobre API RESTful. ¿Cuál es la diferencia entre REST y SOAP?', 'api, rest, web services'),
(2, '¿Cómo puedo aprender JavaScript de manera efectiva?', 'Estoy empezando con JavaScript. ¿Cuáles son los mejores recursos y prácticas para aprenderlo rápidamente?', 'javascript, tutorial, recursos'),
(2, '¿Cómo hacer una consulta con condiciones en SQL?', '¿Cómo puedo hacer una consulta que filtre los resultados usando condiciones WHERE en SQL?', 'sql, consultas, condiciones'),
(2, '¿Qué es un array asociativo en PHP?', 'Estoy aprendiendo PHP y me gustaría saber qué es un array asociativo y cómo se usa.', 'php, arrays, asociativos'),
(2, '¿Cómo implementar un sistema de autenticación en PHP?', 'Quiero crear un sistema de login en PHP. ¿Cuáles son los pasos básicos para implementarlo?', 'php, autenticación, login'),
(2, '¿Qué es la herencia en programación orientada a objetos?', 'Tengo dudas sobre la herencia en POO. ¿Cómo funciona y cuándo se utiliza?', 'poo, herencia, clases'),
(2, '¿Cómo optimizar consultas en MySQL?', '¿Qué estrategias o buenas prácticas me recomiendan para optimizar mis consultas en MySQL?', 'mysql, optimización, consultas'),
(2, '¿Cómo usar el operador ternario en PHP?', '¿Cuál es la sintaxis y el uso del operador ternario en PHP?', 'php, operador ternario'),
(2, '¿Qué son las funciones anónimas en JavaScript?', '¿Cómo se usan las funciones anónimas en JavaScript y cuáles son sus ventajas?', 'javascript, funciones anónimas'),
(2, '¿Qué es un manejador de eventos en JavaScript?', 'Quiero aprender cómo manejar eventos en JavaScript. ¿Cómo puedo hacerlo?', 'javascript, eventos'),
(2, '¿Cómo configurar un servidor Apache en Linux?', '¿Cuál es el proceso para configurar Apache en un servidor Linux?', 'apache, linux, servidor'),
(2, '¿Cómo crear una tabla con claves foráneas en MySQL?', 'Estoy tratando de crear una tabla con claves foráneas en MySQL. ¿Cómo debería hacerlo?', 'mysql, claves foráneas'),
(2, '¿Qué es AJAX y cómo se usa en JavaScript?', '¿Qué es AJAX y cómo puedo usarlo para mejorar la interacción en mis aplicaciones web?', 'ajax, javascript, web'),
(2, '¿Cómo conectarme a una base de datos MySQL con PDO?', 'Quiero aprender a conectarme a una base de datos MySQL usando PDO en PHP. ¿Cómo lo hago?', 'php, mysql, pdo'),
(2, '¿Qué es el patrón MVC?', 'Estoy aprendiendo sobre patrones de diseño. ¿Qué es el patrón MVC y cómo lo implemento en PHP?', 'php, mvc, patrones de diseño'),
(2, '¿Cómo crear una página dinámica en PHP?', 'Quiero hacer una página dinámica con PHP. ¿Cómo puedo hacerlo?', 'php, dinámico, desarrollo web'),
(2, '¿Cómo evitar inyecciones SQL en PHP?', 'Estoy trabajando con formularios en PHP y quiero evitar inyecciones SQL. ¿Cómo puedo protegerme de este tipo de ataques?', 'php, seguridad, inyecciones SQL'),
(2, '¿Qué son los cookies en PHP y cómo se gestionan?', '¿Cómo puedo utilizar y gestionar cookies en PHP para mantener el estado de sesión?', 'php, cookies, sesión'),
(2, '¿Qué es un framework PHP y cuáles son los más populares?', 'Estoy considerando usar un framework PHP. ¿Cuáles son los más populares y qué ventajas ofrecen?', 'php, frameworks, desarrollo web'),
(2, '¿Cómo agregar validación de formulario en JavaScript?', '¿Cómo puedo agregar validación en el lado del cliente usando JavaScript?', 'javascript, validación, formularios'),
(2, '¿Cómo funciona el almacenamiento en caché en MySQL?', '¿Qué es el almacenamiento en caché en MySQL y cómo puedo configurarlo para mejorar el rendimiento?', 'mysql, caché, optimización'),
(2, '¿Qué es un archivo .htaccess y cómo se usa?', 'Estoy aprendiendo sobre archivos .htaccess en Apache. ¿Cuáles son los usos más comunes?', 'apache, htaccess, configuración'),
(2, '¿Qué son las expresiones regulares y cómo se usan en PHP?', '¿Cómo puedo usar expresiones regulares en PHP para validar entradas de usuario?', 'php, expresiones regulares, validación'),
(2, '¿Cómo hacer una conexión a una API externa en PHP?', 'Estoy tratando de consumir una API externa en PHP. ¿Cómo puedo hacer la conexión?', 'php, api, integración'),
(2, '¿Qué son las transacciones en MySQL?', '¿Cómo funcionan las transacciones en MySQL y cómo puedo usarlas para asegurar la integridad de los datos?', 'mysql, transacciones, bases de datos'),
(2, '¿Cómo crear una aplicación CRUD en PHP?', 'Quiero aprender a crear una aplicación CRUD en PHP. ¿Cuáles son los pasos básicos?', 'php, CRUD, desarrollo web'),
(2, '¿Qué es la programación asíncrona en JavaScript?', '¿Cómo funciona la programación asíncrona en JavaScript y cómo puedo implementarla?', 'javascript, asíncrona, promesas'),
(2, '¿Cómo puedo proteger mis contraseñas en PHP?', '¿Cuál es la mejor manera de proteger las contraseñas de los usuarios en PHP?', 'php, contraseñas, seguridad'),
(2, '¿Cómo hacer una redirección 301 en PHP?', '¿Cómo puedo hacer una redirección 301 en PHP para SEO?', 'php, redirección, seo'),
(2, '¿Cómo configurar un servidor Nginx en Ubuntu?', '¿Cómo puedo configurar un servidor Nginx en Ubuntu para una aplicación web?', 'nginx, ubuntu, servidor'),
(2, '¿Qué es el patrón de diseño Singleton?', 'Estoy aprendiendo sobre patrones de diseño. ¿Qué es el patrón Singleton y cuándo usarlo?', 'poo, patrones, singleton'),
(2, '¿Cómo hacer una aplicación de chat en tiempo real con PHP?', 'Quiero hacer una aplicación de chat en tiempo real con PHP. ¿Cómo lo puedo hacer?', 'php, chat, tiempo real'),
(2, '¿Cómo manejar excepciones en PHP?', '¿Cómo puedo manejar excepciones en PHP de manera correcta?', 'php, excepciones, errores'),
(2, '¿Cómo hacer una búsqueda en múltiples tablas en SQL?', '¿Cómo puedo hacer una consulta SQL que busque en varias tablas al mismo tiempo?', 'sql, búsqueda, múltiples tablas'),
(2, '¿Cómo usar la función explode() en PHP?', '¿Qué hace la función explode() en PHP y cómo se usa?', 'php, explode, cadenas'),
(2, '¿Cómo depurar código PHP?', '¿Cuáles son las mejores prácticas para depurar código PHP?', 'php, depuración, errores'),
(2, '¿Cómo generar gráficos con PHP?', '¿Cómo puedo generar gráficos dinámicos en PHP?', 'php, gráficos, visualización'),
(2, '¿Cómo conectar una base de datos MySQL con Python?', '¿Cómo puedo conectar una base de datos MySQL con un script en Python?', 'mysql, python, base de datos'),
(2, '¿Cómo crear un formulario con múltiples pasos en PHP?', '¿Cómo puedo crear un formulario que tenga varios pasos en PHP?', 'php, formularios, varios pasos'),
(2, '¿Cómo gestionar sesiones en PHP?', '¿Cómo gestiono las sesiones de usuario en PHP correctamente?', 'php, sesiones, autenticación'),
(2, '¿Qué es el método POST en HTML?', '¿Cuál es la diferencia entre los métodos GET y POST en HTML y cuándo se debe usar cada uno?', 'html, post, formularios'),
(2, '¿Cómo hacer una validación de email en PHP?', '¿Cómo puedo validar que un email ingresado en un formulario es válido en PHP?', 'php, validación, email'),
(2, '¿Qué son las rutas amigables en PHP?', '¿Cómo puedo implementar rutas amigables en PHP para mejorar la usabilidad de las URLs?', 'php, rutas, seo'),
(2, '¿Cómo implementar un sistema de notificaciones en PHP?', '¿Cómo puedo implementar un sistema de notificaciones en tiempo real en mi aplicación PHP?', 'php, notificaciones, tiempo real'),
(2, '¿Cómo evitar el spam en un formulario de contacto?', '¿Cómo puedo evitar que los formularios de contacto sean usados para enviar spam?', 'php, spam, formulario');

