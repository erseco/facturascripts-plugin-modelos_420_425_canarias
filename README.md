# Modelos 420/425 Canarias

Plugin de FacturaScripts para la generación de los **Modelos 420 y 425** de la **Agencia Tributaria Canaria (ATC)**, utilizados para la declaración del **IGIC (Impuesto General Indirecto Canario)**.

## Descripción

El **IGIC** es el impuesto indirecto que grava el consumo en las Islas Canarias, equivalente al IVA en la península pero con tipos impositivos diferentes.

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

## Uso

### Modelo 420
1. Ir a **Informes > Modelo 420**
2. Seleccionar el período trimestral
3. Pulsar "Calcular" para previsualizar
4. Pulsar "Guardar" para crear la regularización

### Modelo 425
1. Ir a **Informes > Modelo 425**
2. Seleccionar el ejercicio
3. Se mostrará el resumen anual de IGIC devengado y deducible

## Presentación Telemática

El plugin genera el fichero `.dec` necesario para la presentación telemática en la sede electrónica de la Agencia Tributaria Canaria.

### Generar fichero .dec

1. Ir a **Informes > Modelo 420**
2. Seleccionar el período y pulsar "Calcular"
3. Pulsar "Guardar" para crear la regularización
4. Pulsar **"Descargar fichero"** para obtener el `.dec`

### Presentar en la ATC

1. Accede a la [sede electrónica de la ATC](https://sede.gobiernodecanarias.org/tributos/)
2. Selecciona **Modelo 420** > **Presentación telemática**
3. Pulsa "Examinar" y selecciona el fichero `.dec` descargado
4. Completa el proceso de presentación

## Instalación

1. Descarga el ZIP desde [Releases](../../releases/latest)
2. Ve a **Panel de Admin > Plugins** en FacturaScripts
3. Sube el archivo ZIP y activa el plugin

## Normativa

- **Ley 20/1991**, de 7 de junio, modificación del Régimen Económico Fiscal de Canarias
- **Ley 4/2012**, de 25 de junio, medidas administrativas y fiscales
- **Real Decreto 2538/1994**, normas de desarrollo del IGIC

## Enlaces

- [Agencia Tributaria Canaria](https://www3.gobiernodecanarias.org/tributos/)
- [Información Modelo 420](https://www3.gobiernodecanarias.org/tributos/atc/w/modelo-420)

## Créditos

- **Carlos García Gómez** - Autor original
- **Ernesto Serrano** - Actualización para FacturaScripts moderno

## Licencia

LGPL-3.0. Ver [LICENSE](LICENSE) para más detalles.
