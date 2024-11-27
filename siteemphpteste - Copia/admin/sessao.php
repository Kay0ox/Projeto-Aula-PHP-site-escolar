<?php

    function logado() {
        session_start();
        return isset($_SESSION['user_id']);
    }