<?php

$timeStation_A_B = 1;               // time between two station


$timeStation = array(               // array of time
    "A_B" => $timeStation_A_B,
    "B_A" => $timeStation_A_B,

    "B_C" => $timeStation_A_B,
    "C_B" => $timeStation_A_B,

    "C_D" => $timeStation_A_B,
    "D_C" => $timeStation_A_B,

    "D_E" => $timeStation_A_B,
    "E_D" => $timeStation_A_B,

    "E_F" => $timeStation_A_B,
    "F_E" => $timeStation_A_B,

    "F_S" => $timeStation_A_B,
    "S_F" => $timeStation_A_B,

    "S_R" => $timeStation_A_B,
    "R_S" => $timeStation_A_B,

    "R_Q" => $timeStation_A_B,
    "Q_R" => $timeStation_A_B,

    "Q_P" => $timeStation_A_B,
    "P_Q" => $timeStation_A_B,

    "P_O" => $timeStation_A_B,
    "O_P" => $timeStation_A_B,

    "O_N" => $timeStation_A_B,
    "N_O" => $timeStation_A_B,

    "N_M" => $timeStation_A_B,
    "M_N" => $timeStation_A_B,

    "M_L" => $timeStation_A_B,
    "L_M" => $timeStation_A_B,

    "M_J" => $timeStation_A_B,
    "J_M" => $timeStation_A_B,

    "J_I" => $timeStation_A_B,
    "I_J" => $timeStation_A_B,

    "I_H" => $timeStation_A_B,
    "H_I" => $timeStation_A_B,

    "H_G" => $timeStation_A_B,
    "G_H" => $timeStation_A_B,

    "G_C" => $timeStation_A_B,
    "C_G" => $timeStation_A_B,

    "I_Y" => $timeStation_A_B,
    "Y_I" => $timeStation_A_B,

    "Y_Q" => $timeStation_A_B,
    "Q_Y" => $timeStation_A_B,

    "C_X" => $timeStation_A_B,
    "X_C" => $timeStation_A_B,

    "X_Z" => $timeStation_A_B,
    "Z_X" => $timeStation_A_B,

    "Z_W" => $timeStation_A_B,
    "W_Z" => $timeStation_A_B,

    "W_E" => $timeStation_A_B,
    "E_W" => $timeStation_A_B,
);


// start class analyse

class analyse
{

    private $coutTime = array();
    private $lessTime;
    private $positionTime;
    private $cheminFinal = array();


    public $temp = array();


    //    function which count the time for one path

    public function countTime($timeStation,$sortChemin)
    {
        $time = 0;
        for($i=0 ; $i < count($this->temp) ; $i++)
        {
            $time  += $timeStation[$sortChemin[$i].'_'.$sortChemin[$i+1]];
        }
        array_push($this->coutTime,$time);
    }



    // function which get all times in an array

    public function getTime($timeStation,$sortChemin,$gare_depart,$gare_fin)
    {
        for ($i=0 ; $i<count($sortChemin) ; $i++)
        {
            if($sortChemin[$i] == $gare_depart)
            {
                $this->temp = array();

                $continue = true;
                $j=$i;
                do{
                    array_push($this->temp, $sortChemin[$j]);

                    if ($sortChemin[$j] == $gare_fin)
                    {
                        $continue = false;
                    }
                    $j++;
                }while($continue != false);

                $this->countTime($timeStation,$sortChemin);
            }
        }
    }


    //  function which select less time and get the position

    public function searchTime_selectChemin($sortChemin,$gare_depart,$gare_fin)
    {

        $this->lessTime = $this->coutTime[0];
        $this->positionTime = 0;

        for($i=0 ; $i<count($this->coutTime) ; $i++)
        {
            for($j=$i+1 ; $j<count($this->coutTime) ; $j++)
            {
                if($this->coutTime[$j] < $this->lessTime)
                {
                    $this->lessTime = $this->coutTime[$j];
                    $this->positionTime = $j;
                }
            }
        }


        // select path

        $compteur = 0;
        for ($i=0 ; $i<count($sortChemin) ; $i++)
        {
            if($sortChemin[$i] == $gare_depart)
            {
                if($compteur == $this->positionTime)
                {
                    $j = $i;
                    $continue = true;

                    while($continue != false)
                    {
                        array_push($this->cheminFinal,$sortChemin[$j]);

                        if ($sortChemin[$j] == $gare_fin)
                        {
                            $continue = false;
                        }
                        $j++;
                    }
                }
                $compteur +=1;
            }
        }
    }



    // function to call functions use for analyse and return the final path

    public function analyse_time($timeStation,$sortChemin,$gare_depart,$gare_fin)
    {
        $this->getTime($timeStation,$sortChemin,$gare_depart,$gare_fin);
        $this->searchTime_selectChemin($sortChemin,$gare_depart,$gare_fin);

        return $this->cheminFinal;
    }


}   // end class
