<?php
function createUrl($path = ''){
    //Tạo đường dẫn, mặc định là trang chủ
    return 'http://localhost/kickz-khoa/'.$path;
}

function paging($url, $total_records, $current_page, $limit)
{    
    // Tính tổng số trang
    $total_page = ceil($total_records / $limit);
     
    // Giới hạn current_page trong khoảng 1 đến total_page
    if ($current_page > $total_page){
        $current_page = $total_page;
    }
    else if ($current_page < 1){
        $current_page = 1;
    }
     
    // Tìm Start
    $start = ($current_page - 1) * $limit;
 
    $html = '';
     
    // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
    if ($current_page > 1 && $total_page > 1){
        $html .= '<a class="page-btn btn btn-primary flex-center" href="'.str_replace($current_page, $current_page-1, $url).'">Prev</a>';
    }
 
    // Lặp khoảng giữa
    for ($i = 1; $i <= $total_page; $i++){
        // Nếu là trang hiện tại thì hiển thị thẻ span
        // ngược lại hiển thị thẻ a
        if ($i == $current_page){
            $html .= '<span class="page-btn btn btn__disable flex-center ">'.$i.'</span>';
        }
        else{
            $html .= '<a class="page-btn btn btn-primary flex-center" href="'.str_replace('{page}', $i, $url).'">'.$i.'</a>';
        }
    }
 
    // nếu current_page < $total_page và total_page > 1 mới hiển thị nút next
    if ($current_page < $total_page && $total_page > 1){
        $html .= '<a class="page-btn btn btn-primary flex-center" href="'.str_replace($current_page, $current_page+1, $url).'">Next</a>';
    }
     
    // Trả kết quả
    return array(
        'start' => $start,
        'limit' => $limit,
        'html' => $html
    );
}

?>