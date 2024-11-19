<?php
function formatPrice($price)
{
  $newPrice = number_format($price, 0, '', '.');
  return "$newPrice" . "đ";
}
function formatSQLColumnsName($col)
{
  $ref = [
    //SANPHAM
    'MASP' => 'Mã',
    'TENSP' => 'Tên Sản Phẩm',
    'GIA' => 'Giá',
    'MOTA' => 'Mô Tả',
    'SOSAO' => 'Đánh Giá',
    'TENHSX' => 'Tên Hãng',
    'NGSX' => 'Ngày Sản Xuất',
    'KHUYENMAI' => 'Khuyến Mãi',
    'TRANGTHAI' => 'Trạng Thái',
    //HSX
    'MAHSX' => 'Mã HSX',
    'LOGO' => 'Logo',
    //DANHMUC
    'MADM' => 'Mã Danh Mục',
    'TENDM' => 'Tên Danh Mục',
    'MAKC' => 'Mã Kích Cỡ',
    'COGIAY' => 'Cỡ Giày',
    'SOLUONG' => 'Số Lượng',
    //HOADON
    'MAHD' => '',
    'MATK' => '',
    'HOTENKH' => '',
    'EMAIL' => 'Email',
    'SDT' => 'SĐT',
    'DCHI' => 'Địa Chỉ',
    'GHICHU' => 'Ghi Chú',
    'NGLAPHD' => 'Ngày Lập Hóa Đơn',
    'MATT' => 'Mã Trạng Thái',
    //NGUOIDUNG
    'TENTK' => 'Tên Tài Khoản',
    'HOTEN' => 'Họ Tên',
    'NGLAPTK' => 'Ngày Lập Tài Khoản',
  ];
  return $ref[$col];
}
