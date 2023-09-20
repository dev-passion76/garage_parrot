<?php
function getRequeteSql($pdo,$sql){
  try {
      
      // https://phpdelusions.net/pdo_examples/select
      
      return $pdo->query($sql)->fetchAll();
      // and somewhere later:;
  } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
  }
}
?>