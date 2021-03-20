<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/{discord_id}/{compared_discord_id}", name="homepage")
     * @param int $discord_id
     * @return Response
     */
    public function accueil($discord_id = 0, $compared_discord_id = 0): Response
    {
        $waifus = array();
        $waifusofotheruser = array();
        if($discord_id != 0) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://waifubot.kar.wtf/user/'. $discord_id);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $result = json_decode(curl_exec($curl));

            foreach ($result->Waifus as $item) {
                array_push($waifus, [
                    "id" => $item->ID,
                    "name" => $item->Name,
                    "image" => $item->Image
                ]);
            }
        }
        if($compared_discord_id != 0) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'https://waifubot.kar.wtf/user/'. $compared_discord_id);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $result = json_decode(curl_exec($curl));

            foreach ($result->Waifus as $item) {
                array_push($waifusofotheruser, [
                    "id" => $item->ID,
                    "name" => $item->Name,
                    "image" => $item->Image
                ]);
            }
        }


        return $this->render('accueil.html.twig', [
            "waifuList" => $waifus
        ]);
    }
}