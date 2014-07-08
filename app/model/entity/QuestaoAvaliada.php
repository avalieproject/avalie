<?php

class QuestaoAvaliada {

    private $IDAvaliacao;
    private $IDQuestao;
    private $ItNota;

    public function getIDAvaliacao() {
        return $this->IDAvaliacao;
    }

    public function getIDQuestao() {
        return $this->IDQuestao;
    }

    public function getItNota() {
        return $this->ItNota;
    }

    public function setIDAvaliacao($IDAvaliacao) {
        $this->IDAvaliacao = $IDAvaliacao;
    }

    public function setIDQuestao($IDQuestao) {
        $this->IDQuestao = $IDQuestao;
    }

    public function setItNota($ItNota) {
        $this->ItNota = $ItNota;
    }

}
