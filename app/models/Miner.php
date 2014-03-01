<?php

/**
 * Miner class
 * Allows for communication with CGMiner/SGMiner instance through
 * provided socket API
 * @author Kim
 */
class Miner {
            private $socket = null;

    function __construct($addr, $port) {
        $this->socket = $this->getsock($addr, $port);
    }

    function __destruct() {
        if ($this->socket != null)
            socket_close($this->socket);
    }

    public function printReadableResponse($response) {
        print_r($response);
    }

    public function request($cmd) {
 
        if ($this->socket != null) {
            socket_write($this->socket, $cmd, strlen($cmd));
            $line = $this->readsockline($this->socket);

            if (strlen($line) == 0) {
                return $line;
            }


            if (substr($line, 0, 1) == '{')
                return json_decode($line, true);

            // Backup in case using old format of returning value
            // From API documentation
            $data = array();
            $objs = explode('|', $line);
            foreach ($objs as $obj) {
                if (strlen($obj) > 0) {
                    $items = explode(',', $obj);
                    $item = $items[0];
                    $id = explode('=', $items[0], 2);
                    if (count($id) == 1 or !ctype_digit($id[1]))
                        $name = $id[0];
                    else
                        $name = $id[0] . $id[1];

                    if (strlen($name) == 0)
                        $name = 'null';

                    if (isset($data[$name])) {
                        $num = 1;
                        while (isset($data[$name . $num]))
                            $num++;
                        $name .= $num;
                    }

                    $counter = 0;
                    foreach ($items as $item) {
                        $id = explode('=', $item, 2);
                        if (count($id) == 2)
                            $data[$name][$id[0]] = $id[1];
                        else
                            $data[$name][$counter] = $id[0];

                        $counter++;
                    }
                }
            }

            return $data;
        }

        return null;
    }

    private function readsockline() {
        $line = '';
        while (true) {
            $byte = socket_read($this->socket, 1);
            if ($byte === false || $byte === '')
                break;
            if ($byte === "\0")
                break;
            $line .= $byte;
        }
        return $line;
    }

    private function getsock($addr, $port) {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false || $socket === null) {
            $error = socket_strerror(socket_last_error());
            $msg = "socket create(TCP) failed";
            echo "ERR: $msg '$error'\n";
            return null;
        }
        $res = socket_connect($socket, $addr, $port);
        if ($res === false) {
            $error = socket_strerror(socket_last_error());
            $msg = "socket connect($addr,$port) failed";
            echo "ERR: $msg '$error'\n";
            socket_close($socket);
            return null;
        }
        return $socket;
    }

}
