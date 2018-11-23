<?php
//  initialize neighbors for each station

//  subway 1
$voisin_A = array("B");
$voisin_B = array("A","C");
$voisin_C = array("B","D","G","X");
$voisin_D = array("C","E");
$voisin_E = array("D","F","W");
$voisin_F = array("E","S");

// subway 2
$voisin_G = array("C","H");
$voisin_H = array("G","I");
$voisin_I = array("H","J","Y");
$voisin_J = array("I","M");

// subway 3
$voisin_L = array("M");
$voisin_M = array("L","J","N");
$voisin_N = array("M","O");
$voisin_O = array("N","P");

// subway 4
$voisin_P = array("O","Q");
$voisin_Q = array("P","R","Y");
$voisin_R = array("Q","S");
$voisin_S = array("R","F");

// subway 5
$voisin_Y = array("I","Q");

// subway 6
$voisin_X = array("C","Z");
$voisin_Z = array("X","W");
$voisin_W = array("Z","E");




//  tab composed of all neighbors

$voisin_tab = array("A" => $voisin_A,
    "B" => $voisin_B,
    "C" => $voisin_C,
    "D" => $voisin_D,
    "E" => $voisin_E,
    "F" => $voisin_F,
    "G" => $voisin_G,
    "H" => $voisin_H,
    "I" => $voisin_I,
    "J" => $voisin_J,
    "L" => $voisin_L,
    "M" => $voisin_M,
    "N" => $voisin_N,
    "O" => $voisin_O,
    "P" => $voisin_P,
    "Q" => $voisin_Q,
    "R" => $voisin_R,
    "S" => $voisin_S,
    "Y" => $voisin_Y,
    "X" => $voisin_X,
    "Z" => $voisin_Z,
    "W" => $voisin_W
);



// start class chemin

class chemin
{

    public $gare_depart;
    public $gare_fin;
    private $compteur;

    private $continue;
    private $id_tab = array();
    private $sortChemin = array();
    private $finalChemin = array();

    private $chemin = array();
    private $save = array();
    private $transition = array();
    private $transition_tab = array();
    private $ok = array();

    private $visited_tab_total = array();


    public $visited_tab = array(
        "A" => 0,
        "B" => 0,
        "C" => 0,
        "D" => 0,
        "E" => 0,
        "F" => 0,
        "G" => 0,
        "H" => 0,
        "I" => 0,
        "J" => 0,
        "L" => 0,
        "M" => 0,
        "N" => 0,
        "O" => 0,
        "P" => 0,
        "Q" => 0,
        "R" => 0,
        "S" => 0,
        "Y" => 0,
        "X" => 0,
        "Z" => 0,
        "W" => 0
    );



    //  construct

    function __construct($gare_depart = "A", $gare_fin = "F")
    {
        $this->gare_depart = $gare_depart;
        $this->gare_fin =  $gare_fin;
    }



    //  get neighbors of $station

    public function getVoisin($voisin_tab, $station)
    {
        $voisin = array();
        foreach ($voisin_tab[$station] as $v)
        {
            array_push($voisin, $v);
        }

        return $voisin;
    }


    //  copy path since the beginning

    public function copyChemin($var)
    {
        $this->transition = array();

        for ($i = count($this->chemin) ; $i>0 ; $i--)
        {
            if ($this->chemin[$i] == $this->gare_depart)
            {
                $this->compteur = $i;
                break;
            }
        }

        array_push($this->transition, $this->gare_depart);

        for ($k = $this->compteur ; $k < count($this->chemin) ; $k++)
        {
            array_push($this->transition, $this->chemin[$k]);
        }

        $this->transition_tab[$var] = $this->transition;
    }



    //  insert path which was copied

    public function insertChemin($var)
    {
        for ($i=0 ; $i<count($this->transition_tab[$var]) ; $i++)
        {
            array_push($this->chemin, $this->transition_tab[$var][$i]);
        }
    }


    //  initialise the starter

    public function initialiseStart($var)
    {
        if(empty($var))
        {
            $var= $this->gare_depart;
            return $var;
        }
        return $var;
    }


    //  fill visited_tab, which is initialise to 0
    //  because we don't want pass two time in the same path

    public function fillVisited_tab($start)
    {
        $save = array();
        for($i = count($this->chemin) ; $i > 0 ; $i--)
        {
            if($this->chemin[$i] == $this->gare_depart)
            {
                $compteur = $i;
                break;
            }
        }

        for ($j = $compteur ; $j < count(($this->chemin)) ; $j++)
        {
            array_push($save,$this->chemin[$j]);
        }

        foreach ($save as $s)
        {
            $this->visited_tab_total[$start][$s] = 1;
        }
    }


    //  get all paths, from start to end

    public function getChemin($voisin_tab,$start)
    {
        // initialise $start
        $start = $this->initialiseStart($start);

        // get neighbors
        $voisin = $this->getVoisin($voisin_tab,$start);


        $this->visited_tab_total[$start] = $this->visited_tab;
        $this->fillVisited_tab($start);


        if(count($voisin)>2)
        {
            $this->copyChemin($start);
        }

        foreach ($voisin as $l)
        {
            if(($this->visited_tab_total[$start][$l] == 0) || ($this->visited_tab_total[$start][$l]==3))
            {
                $this->visited_tab_total[$start][$l] = 3;
            }
        }


        foreach ($voisin as $v)
        {

            if($this->visited_tab_total[$start][$v] == 3)
            {
                $this->insertChemin($start);
            }


            if(end($this->chemin) != $start)
            {

                if ($this->visited_tab_total[$start][$start] == 0)
                {
                    array_push($this->chemin, $start);
                    $this->visited_tab_total[$start][$start] = 1;
                }
            }


            if ($start == $this->gare_depart)
            {
                if (end($this->chemin) != $this->gare_depart)
                {
                    array_push($this->chemin, $start);
                }
            }


            // ----------------------------------


            if (($this->visited_tab_total[$start][$v]==0) || ($this->visited_tab_total[$start][$v]==3))
            {
                if ($v != $this->gare_fin)
                {
                    array_push($this->chemin, $v);
                    $this->visited_tab_total[$start][$v] = 1;


                    $this->getChemin($voisin_tab, end($this->chemin));

                }
            }

            if ($v == $this->gare_fin)
            {
                array_push($this->chemin, $v);
                $this->visited_tab_total[$start][$v] = 1;

            }
        }
    }


    //  sort path, keep only paths that start and end at the right stations

    public function sortChemin()
    {
        for($i=0 ; $i<count($this->chemin) ; $i++)
        {
            if($this->chemin[$i] == $this->gare_fin)
            {
                $j = $i;
                $this->continue = true;
                do{
                    $j --;

                    if($this->chemin[$j] == $this->gare_depart)
                    {
                        array_push($this->id_tab, $j);
                        array_push($this->id_tab, $i+1);
                        $this->continue = false;
                    }
                }while($this->continue != false);
            }
        }


        for($k=0; $k<count($this->id_tab); $k +=2)
        {
            array_push($this->sortChemin, '#');

            for($comp= $this->id_tab[$k] ; $comp< $this->id_tab[$k+1] ; $comp++)
            {
                array_push($this->sortChemin, $this->chemin[$comp]);

            }
        }
        return $this->sortChemin;
    }


}   // end class
