# CLAUDE.md - Guía de Desarrollo del Plugin Modelos 420/425 Canarias

Este documento contiene las convenciones, estilos de código y mejores prácticas para el desarrollo de este plugin de FacturaScripts.

## Descripción del Plugin

Plugin para la generación de los **Modelos 420 y 425** de la **Agencia Tributaria Canaria (ATC)**, utilizados para la declaración del **IGIC (Impuesto General Indirecto Canario)**.

### Modelo 420 - Autoliquidación Trimestral
- Declaración trimestral del IGIC para empresarios y profesionales
- Plazos de presentación:
  - T1 (enero-marzo): 1-20 abril
  - T2 (abril-junio): 1-20 julio
  - T3 (julio-septiembre): 1-20 octubre
  - T4 (octubre-diciembre): 1-30 enero (año siguiente)

### Modelo 425 - Declaración-Resumen Anual
- Resumen anual de todas las operaciones del ejercicio
- Debe coincidir con la suma de los 4 Modelos 420 trimestrales
- Plazo: 1-30 enero del año siguiente

### Tipos de IGIC
| Tipo | Porcentaje | Aplicación |
|------|------------|------------|
| Cero | 0% | Productos básicos |
| Reducido | 3% | Alimentos, transporte |
| General | 7% | Tipo común |
| Incrementado | 9,5% | Ciertos productos |
| Especial incrementado | 15% | Artículos de lujo |
| Especial | 20% | Tabaco |

## Estructura del Plugin

```
Modelos420_425_Canarias/
├── Controller/
│   ├── Modelo420.php          # Controlador autoliquidación trimestral
│   └── Modelo425.php          # Controlador resumen anual
├── doc/                       # Documentación normativa (no se incluye en releases)
│   ├── NORMATIVA.md           # Enlaces a normativa oficial
│   ├── Instrucciones_modelo_420.pdf  # Instrucciones oficiales ATC
│   └── Manual_Modelo_420.pdf  # Manual del programa de ayuda ATC
├── Lib/
│   └── IGICHelper.php         # Clase auxiliar para cálculos IGIC
├── View/
│   ├── Modelo420.html.twig    # Vista del Modelo 420
│   └── Modelo425.html.twig    # Vista del Modelo 425
├── Translation/
│   └── es_ES.json             # Traducciones en español
├── Test/
│   ├── bootstrap.php
│   ├── install-plugins.php
│   └── main/
│       ├── InitTest.php
│       ├── IGICHelperTest.php
│       └── install-plugins.txt
├── Init.php                   # Clase de inicialización
└── facturascripts.ini         # Metadatos del plugin
```

## Convenciones de Código

### Namespaces
```php
// Controladores
namespace FacturaScripts\Plugins\Modelos420_425_Canarias\Controller;

// Librería auxiliar
namespace FacturaScripts\Plugins\Modelos420_425_Canarias\Lib;
```

### Estilo de Código (PSR-12)
- **Indentación:** 4 espacios (NO tabuladores)
- **Longitud máxima de línea:** 120 caracteres
- **Arrays:** Sintaxis corta `[]`, NO `array()`
- **Strings:** Comillas simples preferidas
- **Coma final:** En arrays multilínea

### Ejemplo de Clase
```php
<?php

namespace FacturaScripts\Plugins\Modelos420_425_Canarias\Controller;

use FacturaScripts\Core\Template\Controller;
use FacturaScripts\Core\Tools;

class Modelo420 extends Controller
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['menu'] = 'reports';
        $data['title'] = 'modelo-420';
        $data['icon'] = 'fa-solid fa-file-invoice';
        return $data;
    }

    public function run(): void
    {
        parent::run();
        // Lógica del controlador
        $this->view('Modelo420');
    }
}
```

## Subcuentas Contables

El plugin utiliza las cuentas especiales definidas en FacturaScripts:
- `IVASOP` - IGIC Soportado (compras)
- `IVAREP` - IGIC Repercutido (ventas)
- `IVAACR` - Hacienda Pública acreedora por IGIC
- `IVADEU` - Hacienda Pública deudora por IGIC

**Nota:** Aunque las constantes usan "IVA" por compatibilidad con FacturaScripts Core, en Canarias se aplica al IGIC.

## Traducciones

Las traducciones están en `Translation/es_ES.json`. Formato:
```json
{
    "clave-traduccion": "Texto traducido",
    "modelo-420": "Modelo 420"
}
```

Uso en PHP:
```php
Tools::lang()->trans('modelo-420')
```

Uso en Twig:
```twig
{{ i18n.trans('modelo-420') }}
```

## Comandos Útiles

```bash
# Iniciar entorno de desarrollo
make up

# Comprobar estilo de código
make lint

# Corregir estilo automáticamente
make format

# Ejecutar tests
make test

# Crear paquete de distribución
make package VERSION=2
```

## Documentación Normativa

La carpeta `doc/` contiene documentación de referencia sobre la normativa del IGIC (no se incluye en releases):

- `doc/NORMATIVA.md` - Recopilación de enlaces a la normativa oficial
- `doc/Instrucciones_modelo_420.pdf` - Instrucciones oficiales de la ATC para cumplimentar el modelo
- `doc/Manual_Modelo_420.pdf` - Manual del programa de ayuda de la ATC

### Formatos de fichero

La ATC utiliza dos formatos de fichero diferentes:

| Formato | Extensión | Uso |
|---------|-----------|-----|
| Intercambio | `.atc` | Importar/exportar entre programas de ayuda |
| Presentación | `.dec` | Presentación telemática en la Sede Electrónica |

**Este plugin puede generar ambos formatos:**

```php
use FacturaScripts\Plugins\Modelos420_425_Canarias\Lib\ATCFileGenerator;

$generator = new ATCFileGenerator($modelo);

// Generar .dec (presentación telemática) - por defecto
$generator->setFormat(ATCFileGenerator::FORMAT_DEC);

// Generar .atc (importación en programa de ayuda)
$generator->setFormat(ATCFileGenerator::FORMAT_ATC);
```

## Referencias

### Enlaces Oficiales
- **Agencia Tributaria Canaria:** https://www3.gobiernodecanarias.org/tributos/
- **Modelo 420:** https://www3.gobiernodecanarias.org/tributos/atc/w/modelo-420
- **Versiones programa de ayuda:** https://www3.gobiernodecanarias.org/tributos/atc/w/modelo-420-versiones-programa-de-ayuda
- **Sede Electrónica ATC:** https://sede.gobiernodecanarias.org/tributos/

### Normativa Principal
- **Ley 20/1991:** Modificación del Régimen Económico Fiscal de Canarias
- **Ley 4/2012:** Medidas administrativas y fiscales (regulación actual del IGIC)
- **Ley 19/1994:** Modificación del Régimen Económico y Fiscal de Canarias
- **Real Decreto 2538/1994:** Normas de desarrollo del IGIC
- **Decreto 268/2011:** Reglamento de gestión de tributos REF de Canarias

### FacturaScripts
- **Documentación:** https://facturascripts.com/documentacion
