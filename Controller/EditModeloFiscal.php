<?php

/**
 * This file is part of Modelos420_425_Canarias plugin for FacturaScripts.
 * Copyright (C) 2026 Ernesto Serrano <info@ernesto.es>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace FacturaScripts\Plugins\Modelos420_425_Canarias\Controller;

use FacturaScripts\Core\Lib\ExtendedController\EditController;
use FacturaScripts\Plugins\Modelos420_425_Canarias\Lib\ATCFileGenerator;
use FacturaScripts\Plugins\Modelos420_425_Canarias\Lib\IGICHelper;
use FacturaScripts\Plugins\Modelos420_425_Canarias\Model\ModeloFiscal;

/**
 * Controlador para editar/visualizar un modelo fiscal.
 */
class EditModeloFiscal extends EditController
{
    public function getModelClassName(): string
    {
        return 'ModeloFiscal';
    }

    protected function execPreviousAction($action): bool
    {
        if ($action === 'download-atc') {
            $this->downloadATC();
            return false;
        }

        return parent::execPreviousAction($action);
    }

    /**
     * Genera y descarga el fichero ATC.
     */
    protected function downloadATC(): void
    {
        $code = $this->request->get('code');
        $modelo = new ModeloFiscal();
        if (false === $modelo->loadFromCode($code)) {
            return;
        }

        $helper = new IGICHelper();
        $generator = new ATCFileGenerator($modelo);

        $desgloseVentas = $helper->desgloseIGICVentas($modelo->fechainicio, $modelo->fechafin);
        $desgloseCompras = $helper->desgloseIGICCompras($modelo->fechainicio, $modelo->fechafin);

        $generator->setDesgloseVentas($desgloseVentas)
            ->setDesgloseCompras($desgloseCompras);

        $filename = $generator->getFilename();
        $content = $generator->generate();

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . strlen($content));
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');

        echo $content;
        exit;
    }

    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data['menu'] = 'reports';
        $data['title'] = 'modelo-fiscal';
        $data['icon'] = 'fa-solid fa-file-invoice';
        $data['showonmenu'] = false;
        return $data;
    }

    protected function createViews(): void
    {
        parent::createViews();
        $this->setTabsPosition('bottom');

        // Botón para descargar fichero ATC
        $this->addButton($this->getMainViewName(), [
            'action' => 'download-atc',
            'icon' => 'fa-solid fa-download',
            'label' => 'descargar-atc',
            'type' => 'link',
        ]);

        // Pestaña de facturas de cliente
        $this->createViewFacturasCliente();

        // Pestaña de facturas de proveedor
        $this->createViewFacturasProveedor();
    }

    protected function createViewFacturasCliente(string $viewName = 'ListModeloFiscalFactura-cliente'): void
    {
        $this->addListView($viewName, 'ModeloFiscalFactura', 'facturas-ventas', 'fa-solid fa-file-invoice');
        $this->views[$viewName]->addOrderBy(['fecha'], 'fecha', 2);
        $this->views[$viewName]->addOrderBy(['codigo'], 'codigo');
        $this->views[$viewName]->addSearchFields(['codigo', 'cifnif', 'nombre']);

        // Deshabilitar botones
        $this->setSettings($viewName, 'btnNew', false);
        $this->setSettings($viewName, 'btnDelete', false);
    }

    protected function createViewFacturasProveedor(string $viewName = 'ListModeloFiscalFactura-proveedor'): void
    {
        $this->addListView($viewName, 'ModeloFiscalFactura', 'facturas-compras', 'fa-solid fa-file-invoice-dollar');
        $this->views[$viewName]->addOrderBy(['fecha'], 'fecha', 2);
        $this->views[$viewName]->addOrderBy(['codigo'], 'codigo');
        $this->views[$viewName]->addSearchFields(['codigo', 'cifnif', 'nombre']);

        // Deshabilitar botones
        $this->setSettings($viewName, 'btnNew', false);
        $this->setSettings($viewName, 'btnDelete', false);
    }

    protected function loadData($viewName, $view): void
    {
        $mvn = $this->getMainViewName();

        switch ($viewName) {
            case 'ListModeloFiscalFactura-cliente':
                $idmodelo = $this->getViewModelValue($mvn, 'idmodelo');
                $where = [
                    new \FacturaScripts\Core\Base\DataBase\DataBaseWhere('idmodelo', $idmodelo),
                    new \FacturaScripts\Core\Base\DataBase\DataBaseWhere('tipofactura', 'cliente'),
                ];
                $view->loadData('', $where);
                break;

            case 'ListModeloFiscalFactura-proveedor':
                $idmodelo = $this->getViewModelValue($mvn, 'idmodelo');
                $where = [
                    new \FacturaScripts\Core\Base\DataBase\DataBaseWhere('idmodelo', $idmodelo),
                    new \FacturaScripts\Core\Base\DataBase\DataBaseWhere('tipofactura', 'proveedor'),
                ];
                $view->loadData('', $where);
                break;

            default:
                parent::loadData($viewName, $view);
                break;
        }
    }
}
