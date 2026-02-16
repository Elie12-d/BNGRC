<?php

namespace app\controllers;
use app\models\BngrcModel;
use Flight;
use flight\Engine;

class BngrcController {
    
    // Afficher le formulaire de besoin
    public static function showBesoinForm() {
        $model = new BngrcModel(Flight::db());
        $villes = $model->getVilles();
        // récupérer la liste des produits disponibles pour la sélection
        $products = [];
        try {
            $products = $model->getProducts();
        } catch (\Throwable $e) {
            // ignore, render will show empty list
        }
        Flight::render('form_besoin', ['villes' => $villes, 'products' => $products]);
    }

    // Traiter la soumission du besoin
    public static function submitBesoin() {
        $model = new BngrcModel(Flight::db());
        $data = Flight::request()->data;
        
        $model->saveBesoin($data->nom, $data->quantite, $data->prix_unitaire, $data->id_ville);
        
        Flight::redirect('/dashboard');
    }

    // Afficher le formulaire de don
    public static function showDonForm() {
        // fournir la liste des produits disponibles pour le select
        $model = new BngrcModel(Flight::db());
        $products = [];
        try {
            $products = $model->getProducts();
        } catch (\Throwable $e) {
            // ignore
        }
        Flight::render('form_don', ['products' => $products]);
    }

    // Traiter la soumission du don
    public static function submitDon() {
        $model = new BngrcModel(Flight::db());
        $data = Flight::request()->data;

        $model->saveDon($data->nom, $data->quantite, $data->date_don);
        
        // C'est ici qu'on appellerait la fonction de dispatching plus tard
        Flight::redirect('/dashboard');
    }
}
