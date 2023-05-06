<?php

namespace App\Core;

class Form
{
    private $formCode = '';

    /**
     * Génère le formulaire HTML
     * @return string
     */
    public function create()
    {
        return $this->formCode;
    }

    /**
     * Valide si tous les champs proposés sont remplis
     * @param array $form Tab issu du form
     * @param array $champs Tableau des champs
     */
    public static function validate(array $form, array $champs)
    {
        //On parcours les champs
        foreach($champs as $champ){
            // echo $champ;
            //si le champ est absent ou vide
            if(!isset($form[$champ]) || empty($form[$champ])) return false;
        }
        return true;
    }

    /**
     * Ajoute les attributs enovoyé
     * @param array $attributs Tableau associatifs ['class' => 'form-control', 'required' => true]
     * @return string string genere
     */
    public function ajoutAttribut(array $attributs)
    {
        //on initialise une chaine de caractère
        $str = '';

        //on liste les attributs courts
        $courts = ['checked', 'disabled', 'readonly', 'required', 'multiple', 'autofocus', 'autocorrect', 'novalidate', 'formnovalidate'];

        foreach($attributs as $attribut => $valeur){
            //si l'attribut est court et sa valeur est true
            if(in_array($attribut, $courts) && $valeur == true){
                $str .= " $attribut";
            }else{
                //on ajoute attribut = 'valeur'
                $str .= " $attribut=\"$valeur\"";
            }
        }
        return $str;
    }

    /**
     * balise d'ouverture du formulaire 
     * @param string $method Methode du formmulaire (post ou get)
     * @param string $action Action du formulaire
     * @param array $attributs Attributs
     * @return From
     */
    public function debutForm(string $method='POST', string $action='#', array $attributs=[]): self
    {
        //On cré la balise form
        $this->formCode .= "<form method=\"$method\" action=\"$action\"";

        //On ajoute les attributs éventuels
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) . '> ': '>';
        return $this;
    }

     /**
     * balise fermuture du formulaire
     */
    public function finForm() :self
    {
        $this->formCode .= '</form>';
        return $this;
    }

    /**
     * ajout d'un label
     * @param string $for nom du label
     * @param string $texte son étiquette
     * @param array $attributs Attributs
     */
    public function ajoutLabelFor(string $for, string $texte, array $attributs=[]): self
    {
        //on ouvre la balise
        $this->formCode .= "<label for=\"$for\"";

        //on ajoute les éventuels attributs
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) . '> ': '>';

        //on ajoute le texte
        $this->formCode .= "$texte </label>";

        return $this;
    }

    public function ajoutInput(string $type, string $nom, array $attributs): self
    {
        //on ouvre la balise
        $this->formCode .= "<input type=\"$type\" name=\"$nom\"";

        //on ajoute les éventuels attributs
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) . '> ': '>';
        
        return $this;
    }

    public function ajoutTextarea(string $nom, string $valeur = "", array $attributs = []): self
    {
        //on ouvre la balise
        $this->formCode .= "<textarea name=\"$nom\"";

        //on ajoute les éventuels attribut
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) . '> ': '>';
        $this->formCode .= "$valeur </textarea>";

        return $this;
    }

    /**
     * ajouter la balise <select>
     * @param string $nom
     * @param array $options ['value':'texte']
     * @param array $attributs
     */
    public function ajoutSelect(string $nom, array $options, array $attributs = []): self
    {
        //on cree le select
        $this->formCode .= "<select name=\"$nom\"";

        //on ajoute les éventuels attributs
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) . '> ': '>';

        //on ajoute les options
        foreach($options as $valeur => $texte){
            $this->formCode .= "<option value=\"$valeur\">$texte</option>";
        }
        $this->formCode .= "</select>";

        return $this;
    }

    public function ajoutBouton(string $texte, array $attributs = []):self
    {
        //on ouvre le button
        $this->formCode .= "<button";

        //on ajoute les éventuels attributs
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) . '> ': '>';

        $this->formCode .= "$texte </button>";

        return $this;
    }

    /**
     * ajout des tagHtml
     * @param string $tag like p,a,h1,.....
     * @param string $texte 
     * @param array $attributs 
     */
    public function debutTag(string $tag, string $texte='', array $attributs = []):self
    {
        $this->formCode .= "<$tag ";
        $this->formCode .= $attributs ? $this->ajoutAttribut($attributs) . "> $texte": "> $texte";
        return $this;
    }

    public function finTag(string $tag)
    {
        $this->formCode .= "</$tag>";
        return $this;
    }

}