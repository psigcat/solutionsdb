## Documentación

### Estructura directorios

- **contenidos/**
  - A este directorio se suben los contenidos generados online. 
- **docs/**
  - Documentación del proyecto
  - Parches SQL (Parche1.sql, Parche2.sql, ...)
- **includes/**
  - Constantes de texto, geoip, recursos comununes
- **libs/**
  - Lógica, modelos.
- **js/**
  - Librerías propias minificadas.
  - **libs/**
    - Librerías externas
  - **masters/**
    - Librerías propias sin minificar
- **tpl/**
  - **\<nombre_template/default\>/**
    - Plantillas gráficas. HTML y JS. El Javascript que sea necesario para la plantilla en concreto, el otro irá en ```../../js/```

### Funcionamiento
- Todos los php instancian a ```lbs/utils/class.system.php```
- **En la raiz están los controllers** (*.php), que llaman a los correspondientes modelos y le pasan los datos a las plantillas html que están en tpl/nombre_template mediante el sistema de plantillas que incorpora System.
- **Para el update en caso de problemas revisar class.db.php método ```_set_dbids()```.**

```PHP
# libs/utils/class.db.php
private static function _set_dbids(){
    $dbids = new DBids();
    $dbids->add('PRUEBA', 'id'); // (tabla,columna)
    $dbids->add('LINKS', 'id'); // (tabla,columna)
    return ($dbids);
}
```

### Config
- En ```libs/``` hay un ```config_demo.php```.
  - Cada máquina tiene su propio config
  - **El archivo ```config_demo.php``` debería ser el correcto para la máquina en producción, este sí se versiona**.
  - El archivo ```config.php``` **no se versiona** y será el que toque para cada máquina, en el caso de producción debería ser una copia de ```config_demo.php```.
- Cada módulo se guarda en un directorio (p. ej.: ```/libs/ususarios/class.usuarios.php```).
- En ```utils/``` están las clases comunes (acceso a bd, parseado de fechas, el motor de templates, system, etc...)