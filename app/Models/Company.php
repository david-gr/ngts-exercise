<?php

class Company extends Model
{

    const WITHOUT_PARENT = -1;

    /**
     * Constructor de la clase. El orden de las ciudades (nodos) debe ser el mismo en la matriz de
     * adyacencia y en el array con los nombres.
     *
     * @param string $name Nombre de la empresa
     * @param array $adjacencyMatrix Matriz de adyacencia de los nodos (dados un origen y un destino
     * nos devuelve el coste del trayecto)
     * @param array $cities Nombres de las ciudades
     *
     * @return Company
     */
    public function __construct(
        private string $name,
        private array $adjacencyMatrix,
        private array $cities) {}

    /**
     * Devuelve el array con los nombres de las ciudades en las que la compañía presta servicio
     *
     * @return array Devuelve el array con los nombres de las ciudades
     */
    public function getCities() {
        return $this->cities;
    }

    /**
     * Devuelve el nombre de la ciudad que se encuentra en el índice especificado
     *
     * @param int $index Índice de la ciudad cuyo nombre se quiere recoger
     *
     * @return string Devuelve el nombre de la ciudad especificada o "Unknown" si el índice no existe
     */
    public function getCityName($index) {
        return array_key_exists($index, $this->cities) ? $this->cities[$index] : 'Unknown';
    }

    /**
     * Devuelve los datos de las rutas de menor coste a partir del origen especificado.
     * Devuelve un array en el que cada elemento representa un trayecto y contiene los siguientes datos:
     * - origin: Ciudad de origen
     * - destination: Ciudad de destino
     * - cost: Coste del trayecto (menor coste encontrado)
     * - path: Array con las ciudades que forman la ruta
     *
     * Si no se especifica un destino se devolverán las rutas de menor coste desde el origen a todos
     * los destinos.
     *
     * @param int $from Índice de la ciudad de origen
     * @param int $to Índice de la ciudad de destino (por defecto -1 para mostrar todos los destinos)
     *
     * @return array Devuelve un array con la información de las rutas de menor coste
     */
    public function getMinimumCostPaths($from, $to = -1) {
        $data = $this->dijkstra($from);
        $result = array();

        if (-1 == $to) {
            unset($data['shortestDistances'][$from]);
            $distances = $data['shortestDistances'];
        } else {
            $distances = array($to => $data['shortestDistances'][$to]);
        }

        foreach ($distances as $destination => $cost) {
            $result[] = array(
                'origin' => $this->getCityName($from),
                'destination' => $this->getCityName($destination),
                'cost' => $cost,
                'path' => $this->getPath($destination, $data['parents'])
            );
        }

        return $result;
    }

    /**
     * Devuelve un array con las ciudades que forman la ruta de menor coste hasta la ciudad
     * con el índice especificado.
     *
     * @param int $node Índice de la ciudad destino
     * @param array $parents Array con los índices de las ciudades de destino como claves y los
     * índices de las ciudades previas en la ruta de menor coste como valores (la ciudad de origen
     * tiene un -1 como valor)
     *
     * @return array Devuelve un array con los nombres de las ciudades que forman el trayecto
     * de menor coste
     */
    private function getPath($node, $parents) {
        $path = array();

        while (self::WITHOUT_PARENT != $node) {
            $path[] = $this->getCityName($node);
            $node = $parents[$node];
        }

        return array_reverse($path);
    }

    /**
     * Algoritmo de búsqueda del camino de menor coste desde la ciudad especificada.
     * Devuelve un array con las siguientes claves:
     * - shortestDistances: Array con los índices de las ciudades de destino como claves
     *      y los costes (el menor encontrado) como valores
     * - parents: Un array con los índices de las ciudades como claves y la ciudad "previa"
     *      en el camino de menor coste como valor
     *
     * @param int $startNode Índice de la ciudad de origen
     *
     * @return array Devuelve un array con el menor coste y la ruta a seguir para todos los destinos
     * a partir del origen especificado
     */
    private function dijkstra($startNode) {

        $nodesNumber = count($this->adjacencyMatrix);
        $shortestDistances = array();
        $included = array();
        $parents = array();
        $parents[$startNode] = self::WITHOUT_PARENT;

        for ($i = 0; $i < $nodesNumber; $i++) {
            $shortestDistances[$i] = INF;
            $included[$i] = false;
        }
        $shortestDistances[$startNode] = 0;

        for ($i = 0; $i < $nodesNumber; $i++) {
            $closestNode = self::WITHOUT_PARENT;
            $shortestDistance = INF;

            for ($nodeIndex = 0; $nodeIndex < $nodesNumber; $nodeIndex++) {
                if (!$included[$nodeIndex] && $shortestDistances[$nodeIndex] < $shortestDistance) {
                    $closestNode = $nodeIndex;
                    $shortestDistance = $shortestDistances[$nodeIndex];
                }
            }

            $included[$closestNode] = true;

            for ($nodeIndex = 0; $nodeIndex < $nodesNumber; $nodeIndex++) {
                $edgeDistance = $this->adjacencyMatrix[$closestNode][$nodeIndex];

                if ($edgeDistance > 0 && (($shortestDistance + $edgeDistance) < $shortestDistances[$nodeIndex])) {
                    $parents[$nodeIndex] = $closestNode;
                    $shortestDistances[$nodeIndex] = $shortestDistance + $edgeDistance;
                }
            }
        }

        return array(
            'shortestDistances' => $shortestDistances,
            'parents' => $parents
        );
    }

}
