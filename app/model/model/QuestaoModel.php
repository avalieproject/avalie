<?php

class QuestaoModel {

    public function listAll() {
        $QuestaoDAO = DAOFactory::getDAO(DB_SYSTEM)->questao();
        $ArQuestoes = $QuestaoDAO->listAll();
        return $ArQuestoes;
    }

}
