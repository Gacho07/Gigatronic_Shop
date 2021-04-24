<?php

function getAllUsers() {
    return executeQuery("SELECT * FROM user u INNER JOIN role r ON u.idRole = r.idRole");
}

function getAllRoles() {
    return executeQuery("SELECT * FROM role");
}