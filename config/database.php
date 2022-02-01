<?php 

function getDatabaseConfig(): array{
  return [
    "database" => [
      "test" => [
        "url" => "mysql:host=localhost:3306;dbname=db_web_smk_test",
        "username" => "root",
        "password" => ""
      ],
      "prod" => [
        "url" => "mysql:host=localhost:3306;dbname=db_web_smk",
        "username" => "root",
        "password" => ""
      ]  
    ]
  ];
}