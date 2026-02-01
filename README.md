# Modelos 420/425 Canarias

Plugin de FacturaScripts para la generación de los **Modelos 420 y 425** de la **Agencia Tributaria Canaria (ATC)**, utilizados para la declaración del **IGIC (Impuesto General Indirecto Canario)**.

## Descripción

El **IGIC (Impuesto General Indirecto Canario)** es el impuesto indirecto que grava el consumo en las Islas Canarias, equivalente al IVA en la península pero con tipos impositivos diferentes.

Este plugin proporciona:

- **Modelo 420**: Autoliquidación trimestral del IGIC
- **Modelo 425**: Declaración-resumen anual del IGIC

## Tipos de IGIC

| Tipo | Porcentaje | Aplicación |
|------|------------|------------|
| Cero | 0% | Productos básicos, exportaciones |
| Reducido | 3% | Alimentos, transporte, vivienda |
| General | 7% | Tipo común |
| Incrementado | 9,5% | Ciertos productos |
| Especial incrementado | 15% | Artículos de lujo |
| Especial | 20% | Tabaco |

## Plazos de Presentación

### Modelo 420 (Trimestral)
- **T1** (enero-marzo): del 1 al 20 de abril
- **T2** (abril-junio): del 1 al 20 de julio
- **T3** (julio-septiembre): del 1 al 20 de octubre
- **T4** (octubre-diciembre): del 1 al 30 de enero del año siguiente

### Modelo 425 (Anual)
- Del 1 al 30 de enero del año siguiente

## Requisitos

- FacturaScripts 2025 o superior
- PHP 8.2 o superior

## Instalación

1. Descargar el archivo ZIP del plugin
2. Ir a **Administración > Plugins** en FacturaScripts
3. Subir el archivo ZIP
4. Activar el plugin

## Uso

### Modelo 420
1. Ir a **Informes > Modelo 420**
2. Seleccionar el período trimestral
3. Pulsar "Calcular" para previsualizar el asiento
4. Pulsar "Guardar" para crear la regularización

### Modelo 425
1. Ir a **Informes > Modelo 425**
2. Seleccionar el ejercicio
3. Se mostrará el resumen anual de IGIC devengado y deducible

## Normativa

Este plugin se basa en la siguiente normativa:

- **Ley 20/1991**, de 7 de junio, de modificación de los aspectos fiscales del Régimen Económico Fiscal de Canarias
- **Ley 4/2012**, de 25 de junio, de medidas administrativas y fiscales
- **Real Decreto 2538/1994**, de 29 de diciembre, normas de desarrollo del IGIC
- **Decreto 268/2011**, de 4 de agosto, Reglamento de gestión de tributos REF

## Enlaces Útiles

- [Agencia Tributaria Canaria](https://www3.gobiernodecanarias.org/tributos/)
- [Información Modelo 420](https://www3.gobiernodecanarias.org/tributos/atc/w/modelo-420)
- [FacturaScripts](https://facturascripts.com)

## Licencia

Este plugin está licenciado bajo **GNU Lesser General Public License v3.0** (LGPL-3.0).

## Desarrollo

### Requisitos de desarrollo
- Docker y Docker Compose
- Make (opcional, para comandos simplificados)

### Comandos útiles

```bash
# Iniciar entorno de desarrollo
make up

# Comprobar estilo de código
make lint

# Ejecutar tests
make test

# Crear paquete de distribución
make package VERSION=2
```

## Créditos

- **Carlos García Gómez** - Autor original
- **Ernesto Serrano** - Actualización para FacturaScripts moderno

## Soporte

Para reportar errores o solicitar funcionalidades, abra un issue en el repositorio de GitHub.
