<?php

function getMenuForAllUsers()
{
    return executeQuery("SELECT * FROM menu WHERE idMenuGroup = 1");
}

function getMenuForAuthorizedUsers()
{
    return executeQuery("SELECT * FROM menu WHERE idMenuGroup = 2");
}

function getMenuForAdmin()
{
    return executeQuery("SELECT * FROM menu WHERE idMenuGroup = 3");
}

function getCategories()
{
    return executeQuery("SELECT * FROM category");
}

