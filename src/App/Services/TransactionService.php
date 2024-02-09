<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
  public function __construct(private Database $db)
  {
  }
  public function create(array $formData)
  {
    $formattedDate = "{$formData['date']} 00:00:00";
    $this->db->query(
      "insert into transaction(user_id, description, amount, date) values (:user_id, :description, :amount, :date)",
      [
        "user_id" => $_SESSION["user"],
        "description" => $formData["description"],
        "amount" => $formData["amount"],
        'date' => $formattedDate
      ]
    );
  }
  public function getUserTransactions(int $length, int $offset)
  {
    $searchTerm = addcslashes($_GET['s'] ?? '', '%_');
    $params = [
      "user_id" => $_SESSION["user"],
      "description" => "%{$searchTerm}%"
    ];
    $transactions = $this->db->query(
      "select *, DATE_FORMAT(date, '%Y-%m-%d')as formatted_date from transaction where user_id = :user_id and description like :description limit {$length} offset {$offset}",
      $params
    )->findAll();

    $transactions = array_map(function (array $transaction) {
      $transaction['receipts'] = $this->db->query(
        "select * from receipts where transaction_id = :transaction_id",
        ['transaction_id' => $transaction['id']]
      )->findAll();
      return $transaction;
    }, $transactions);

    $transactionCount = $this->db->query(
      "select count(*) from transaction where user_id = :user_id and description like :description",
      $params
    )->count();
    return [$transactions, $transactionCount];
  }
  public function getUserTransaction(string $id)
  {
    return $this->db->query(
      "select *, DATE_FORMAT(date, '%Y-%m-%d') as formatted_date from transaction where id = :id and user_id = :user_id",
      [
        'id' => $id,
        'user_id' => $_SESSION['user']
      ]
    )->find();
  }
  public function update(array $formData, int $id)
  {
    $formatted_date = "{$formData['date']} 00:00:00";
    $this->db->query(
      "update transaction set description = :description, amount = :amount, date = :date where id = :id and user_id = :user_id",
      [
        'description' => $formData['description'],
        'amount' => $formData['amount'],
        'date' => $formatted_date,
        'id' => $id,
        'user_id' => $_SESSION['user']
      ]
    );
  }
  public function delete(int $id)
  {
    $this->db->query(
      "delete from transaction where id = :id and user_id = :user_id",
      [
        'id' => $id,
        'user_id' => $_SESSION['user']
      ]
    );
  }
}
