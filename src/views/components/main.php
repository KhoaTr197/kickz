<?php
  include 'filterPanel.php';
  include 'productList.php';

  function main_render() {
    $FilterPanel = filterPanel_render();
    $ProductList = ProductList_render();

    return "
    <main class='main'>
      <div class='wide'>
        <div class='row'>
          $FilterPanel
          $ProductList
        </div>
      </div>
    </main>";
  };
?>