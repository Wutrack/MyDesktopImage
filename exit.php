<?php
include './session.php';
          session_start();
          if    (empty($_SESSION['login']) or empty($_SESSION['pass'])) 
          {
          //���� �� ���������� ������ � ������� � �������, ������ ��    ���� ���� ����� ���������� ������������. ��� ��� �� �����. ������ ���������    �� ������, ������������� ������
          exit ("������ �� ���    �������� �������� ������ ������������������ �������������. ���� ��    ����������������, �� ������� �� ���� ��� ����� ������� � �������<br><a    href='index.php'>�������    ��������</a>");
          }
          
unset($_SESSION['pass']);
            $login = $_SESSION['login'];
            mysqli_query($db, "UPDATE users SET lastdata = NOW() WHERE login = '$login'");
            unset($_SESSION['login']); 
            unset($_SESSION['idusers']);//    ���������� ���������� � �������
            
        exit("<html><head><meta    http-equiv='Refresh' content='0;    URL=index.php'></head></html>");
            // ���������� ������������ �� ������� ��������.
            ?>