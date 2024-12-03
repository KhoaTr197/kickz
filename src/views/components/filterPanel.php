<?php
function filterPanel_render(
  $filterListData=[],
  $mode='button',
  $layout='row'
)
{
  $newQueryStr = "";
  $filterList_html = "";
  $gridClass = $layout == 'column' ? 'col l-2 c-12 no-gutter' : '';
  
  foreach($_GET as $key => $value) {
    if(array_key_exists($key, $filterListData)) continue;
    $newQueryStr .= "$key=$value&";
  }

  switch($mode) {
    case 'button': {
      $filterItems="";
      
      foreach($filterListData as $filterListName => $filterList) {
        if(!isset($_GET[$filterListName]))
          return header("location: ?{$newQueryStr}$filterListName=none");
        foreach($filterList as $filterKey => $filterValue) {
          $isActived = (isset($_GET[$filterListName]) and $filterKey == $_GET[$filterListName]) ? 'filter-list__item--active' : '';

          $filterItems .= "
            <a class='filter-list__item $isActived flex flex-center btn rounded-lg' href='?{$newQueryStr}$filterListName=$filterKey'>$filterValue</a>
          ";
        }
      }
      $filterList_html .= "
        <ul class='filter-list flex'>
          $filterItems
        </ul>
      ";
      break;
    }
    case 'checkbox': {
      $filterItems="";
      
      foreach($filterListData as $filterListName => $filterList) {
        $filterItems .= "<li class='filter-list__title'>".formatName($filterListName)."</li>";
        $filterItems .= '<ul>';
        foreach($filterList as $filterKey => $filterValue) {
          $isChecked = (isset($_GET[$filterListName]) and $filterKey == $_GET[$filterListName]) ? 'checked' : '';

          $filterItems .= "
            <li class='filter-list__item'>
              <label class='checkbox'>
              <div class='checkbox-wrap'>
                <input type='checkbox' value='$filterListName=$filterKey' $isChecked>
                <span class='checkmark'></span>
              </div>
              <span class='checkbox-label'>$filterValue</span>
              </label>
            </li>
          ";
        }
        $filterItems .= '</ul>';
      }
      $filterList_html .= "
        <ul class='filter-list'>
          $filterItems
        </ul>
      ";
      break;
    }
  }

  return "
    <div id='filter-panel' class='filter-panel--$layout $gridClass'>
      <div class='filter-panel-wrap'>
        $filterList_html
      </div>
    </div>
  ";
}
?>