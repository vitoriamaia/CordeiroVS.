<?php

class Model_Collect_Connect
{

    private $dbserver = '186.215.109.253';
    private $dbuserv = 'cmnet';
    private $dbpass = '39272436561';
    private $dbase = 'cm_site';
    private $port = '4406';
    private $link;

    protected function connect_open(){


        try {

            $this->link = new mysqli($this->dbserver, $this->dbuserv, $this->dbpass, $this->dbase, $this->port);

        }
        catch( Exception $e ) {

            $this->connect_close();

        }

    }

    protected function connect_link(){

        return $this->link;

    }

    protected function connect_close(){
        
        mysqli_close($this->link);

    }

}