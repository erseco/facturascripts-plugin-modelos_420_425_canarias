# Fixtures - Ficheros de ejemplo para presentacion telematica (.dec)

Esta carpeta contiene ficheros de ejemplo en formato `.dec` para la presentacion telematica
del Modelo 420 ante la Agencia Tributaria Canaria.

## Formatos de fichero de la ATC

La Agencia Tributaria Canaria utiliza dos formatos de fichero diferentes:

| Formato | Extension | Uso |
|---------|-----------|-----|
| **Fichero de intercambio** | `.atc` | Importar/exportar declaraciones entre programas de ayuda |
| **Fichero de presentacion** | `.dec` | Presentacion telematica en la Sede Electronica de la ATC |

**Este plugin puede generar ambos formatos:**
- `.dec` (por defecto): Para presentacion telematica directa
- `.atc`: Para importar en el programa de ayuda de la ATC y revisar antes de presentar

El programa de ayuda de la ATC permite:
- Importar ficheros `.atc` para cargar declaraciones de otros sistemas
- Exportar ficheros `.atc` para guardar declaraciones
- Generar ficheros `.dec` para la presentacion telematica

## Formato del fichero .dec

El formato `.dec` utilizado para la presentacion telematica es:

1. **XML** - Estructura de datos con la declaracion
2. **Compresion zlib** - El XML se comprime usando `gzdeflate` (raw deflate, nivel 9)
3. **Codificacion uuencode** - Los datos comprimidos se codifican en uuencode

### Proceso de generacion

```php
$xml = generateXML();           // Genera el XML de la declaracion
$compressed = gzdeflate($xml, 9); // Comprime con zlib
$dec = convert_uuencode($compressed); // Codifica en uuencode
```

### Proceso de decodificacion

```php
$decoded = convert_uudecode($decContent); // Decodifica uuencode
$xml = gzinflate($decoded);               // Descomprime zlib
```

## Estructura del XML

```xml
<?xml version="1.0" encoding="ISO-8859-1"?>
<DECLARACION>
  <CABECERA>
    <TIPO>DEC</TIPO>
    <MODELO>420</MODELO>
    <EJERCICIO>2025</EJERCICIO>
    <PERIODO>1T</PERIODO>
    <VERSION>9.2.0</VERSION>
  </CABECERA>
  <SUJETO>
    <NIF>B12345678</NIF>
    <NOMBRE>EMPRESA EJEMPLO SL</NOMBRE>
    <APELLIDOS></APELLIDOS>
    <PROVINCIA>35</PROVINCIA>
    <MUNICIPIO>35016</MUNICIPIO>
    <CODIGO_POSTAL>35001</CODIGO_POSTAL>
    <PAIS>ES</PAIS>
  </SUJETO>
  <IVA_DEVENGADO>
    <REGISTRO>
      <BASE>1000.00</BASE>
      <TIPO>7.00</TIPO>
      <CUOTA>70.00</CUOTA>
    </REGISTRO>
    <TOTAL_CUOTA>70.00</TOTAL_CUOTA>
  </IVA_DEVENGADO>
  <IVA_DEDUCIBLE>
    <TOTAL>35.00</TOTAL>
  </IVA_DEDUCIBLE>
  <RESULTADO>
    <CUOTA_RESULTANTE>35.00</CUOTA_RESULTANTE>
    <FORMA_PAGO>1</FORMA_PAGO>
    <IBAN></IBAN>
  </RESULTADO>
</DECLARACION>
```

## Codigos de provincia (Canarias)

| Codigo | Provincia |
|--------|-----------|
| 35 | Las Palmas |
| 38 | Santa Cruz de Tenerife |

## Periodos

| Codigo | Periodo |
|--------|---------|
| 1T | Primer trimestre (enero-marzo) |
| 2T | Segundo trimestre (abril-junio) |
| 3T | Tercer trimestre (julio-septiembre) |
| 4T | Cuarto trimestre (octubre-diciembre) |
| 0A | Anual (Modelo 425) |

## Ficheros de ejemplo

- `modelo420_ejemplo_positivo.dec` - Ejemplo con resultado a ingresar
- `modelo420_ejemplo_negativo.dec` - Ejemplo con resultado a compensar
- `modelo420_ejemplo_cero.dec` - Ejemplo sin actividad

## Nota importante

Estos ficheros son ejemplos para pruebas unitarias y no deben usarse
para presentaciones reales ante la ATC.
