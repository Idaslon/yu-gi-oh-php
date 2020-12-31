<?php

function criarTabelaPartidas($conexao) {
  $criarTabela = $conexao->query('CREATE TABLE TB_PARTIDAS (
    PAR_CODIGO INT AUTO_INCREMENT PRIMARY KEY,
    PAR_RODADAS INT NOT NULL,
    PAR_TIV_CODIGO INT NOT NULL REFERENCES TB_TIPOSVITORIA(TIV_CODIGO),
    PAR_JOGVEN_CODIGO INT NOT NULL REFERENCES TB_JOGARES(JOG_CODIGO),

    PAR_JOG1_CODIGO INT NOT NULL REFERENCES TB_JOGARES(JOG_CODIGO),
    PAR_JOG1_DEC_CODIGO INT NOT NULL REFERENCES TB_DECKS(DEC_CODIGO),
    PAR_JOG1_VIDAFINAL INT NOT NULL,
    PAR_JOG1_QTDCARTASFINAL INT NOT NULL,

    PAR_JOG2_CODIGO INT NOT NULL REFERENCES TB_JOGARES(JOG_CODIGO),
    PAR_JOG2_DEC_CODIGO INT NOT NULL REFERENCES TB_DECKS(DEC_CODIGO),
    PAR_JOG2_VIDAFINAL INT NOT NULL,
    PAR_JOG2_QTDCARTASFINAL INT NOT NULL
  )');

  if($criarTabela === true) {
    echo "Tabela criada: TB_PARTIDAS <br>";
  } else {
    echo "Erro ao criar tabela TB_PARTIDAS -> " . $conexao->error;
  }
}

function insertPartida(
    $conexao, $PAR_RODADAS, $PAR_TIV_CODIGO,$PAR_JOGVEN_CODIGO,
    $PAR_JOG1_CODIGO, $PAR_JOG1_DEC_CODIGO, $PAR_JOG1_VIDAFINAL, $PAR_JOG1_QTDCARTASFINAL,
    $PAR_JOG2_CODIGO, $PAR_JOG2_DEC_CODIGO, $PAR_JOG2_VIDAFINAL, $PAR_JOG2_QTDCARTASFINAL
  ) {

  $insertQuery = $conexao->query("INSERT INTO TB_PARTIDAS
    (
      PAR_RODADAS, PAR_TIV_CODIGO, PAR_JOGVEN_CODIGO,
      PAR_JOG1_CODIGO, PAR_JOG1_DEC_CODIGO, PAR_JOG1_VIDAFINAL, PAR_JOG1_QTDCARTASFINAL,
      PAR_JOG2_CODIGO, PAR_JOG2_DEC_CODIGO, PAR_JOG2_VIDAFINAL, PAR_JOG2_QTDCARTASFINAL
    )
    values
    (
      '$PAR_RODADAS', '$PAR_TIV_CODIGO','$PAR_JOGVEN_CODIGO',
      '$PAR_JOG1_CODIGO', '$PAR_JOG1_DEC_CODIGO', '$PAR_JOG1_VIDAFINAL', '$PAR_JOG1_QTDCARTASFINAL',
      '$PAR_JOG2_CODIGO', '$PAR_JOG2_DEC_CODIGO', '$PAR_JOG2_VIDAFINAL', '$PAR_JOG2_QTDCARTASFINAL'
    )
  ");

  if($insertQuery === true) {
    echo "Inserido com sucesso: $PAR_RODADAS / $PAR_TIV_CODIGO / $PAR_JOGVEN_CODIGO <br>";
    echo "Inserido com sucesso: $PAR_JOG1_CODIGO / $PAR_JOG1_DEC_CODIGO / $PAR_JOG1_VIDAFINAL / $PAR_JOG1_QTDCARTASFINAL <br>";
    echo "Inserido com sucesso: $PAR_JOG2_CODIGO / $PAR_JOG2_DEC_CODIGO / $PAR_JOG2_VIDAFINAL / $PAR_JOG2_QTDCARTASFINAL <br>";
  } else {
    echo "Erro inserir valor: $PAR_RODADAS / $PAR_TIV_CODIGO / $PAR_JOGVEN_CODIGO " . $conexao->error;
  }
}

function selectPartidas($conexao, $campos) {
  $consulta = $conexao->query("
    SELECT $campos FROM TB_PARTIDAS
    JOIN TB_TIPOSVITORIA ON PAR_TIV_CODIGO = TIV_CODIGO
    JOIN TB_JOGADORES JOGVEN ON PAR_JOGVEN_CODIGO = JOGVEN.JOG_CODIGO
    JOIN TB_JOGADORES JOG1 ON PAR_JOG1_CODIGO = JOG1.JOG_CODIGO
    JOIN TB_JOGADORES JOG2 ON PAR_JOG2_CODIGO = JOG2.JOG_CODIGO
    JOIN TB_DECKS DEC1 ON PAR_JOG1_DEC_CODIGO = DEC1.DEC_CODIGO
    JOIN TB_DECKS DEC2 ON PAR_JOG2_DEC_CODIGO = DEC2.DEC_CODIGO
  ");

  $array = [];

  while($row = $consulta->fetch_assoc()) {
    array_push($array, $row);
  }

  return $array;
}

?>
