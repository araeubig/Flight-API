<?php

namespace App\Models;

use App\Database\Database;
use PDO;

class Value
{
    public $id;
    public $s_ts;
    public $s_pr;
    public $s_ng;
    public $s_dg;
    public $s_cn;
    public $s_op;
    public $s_sc;
    public $t_r0;
    public $t_r1;
    public $t_r2;
    public $t_r4;
    public $h_r0;
    public $h_r1;
    public $h_r2;
    public $h_r4;
    public $c_r1;
    public $c_r2;
    public $c_r4;
    public $a_r1;
    public $a_r2;
    public $a_r4;
    public $i_r1;
    public $i_r2;
    public $i_r4;
    public $e_r1;
    public $e_r2;
    public $e_r4;

    public function __construct(
        $id     = null,
        $s_ts   = null,
        $s_pr   = null,
        $s_ng   = null,
        $s_dg   = null,
        $s_cn   = null,
        $s_op   = null,
        $s_sc   = null,
        $t_r0   = null,
        $t_r1   = null,
        $t_r2   = null,
        $t_r4   = null,
        $h_r0   = null,
        $h_r1   = null,
        $h_r2   = null,
        $h_r4   = null,
        $c_r1   = null,
        $c_r2   = null,
        $c_r4   = null,
        $a_r1   = null,
        $a_r2   = null,
        $a_r4   = null,
        $i_r1   = null,
        $i_r2   = null,
        $i_r4   = null,
        $e_r1   = null,
        $e_r2   = null,
        $e_r4   = null
    )
    {
        $this->id   = $id;
        $this->s_ts = $s_ts;
        $this->s_pr = $s_pr;
        $this->s_ng = $s_ng;
        $this->s_dg = $s_dg;
        $this->s_cn = $s_cn;
        $this->s_op = $s_op;
        $this->s_sc = $s_sc;
        $this->t_r0 = $t_r0;
        $this->t_r1 = $t_r1;
        $this->t_r2 = $t_r2;
        $this->t_r4 = $t_r4;
        $this->h_r0 = $h_r0;
        $this->h_r1 = $h_r1;
        $this->h_r2 = $h_r2;
        $this->h_r4 = $h_r4;
        $this->c_r1 = $c_r1;
        $this->c_r2 = $c_r2;
        $this->c_r4 = $c_r4;
        $this->a_r1 = $a_r1;
        $this->a_r2 = $a_r2;
        $this->a_r4 = $a_r4;
        $this->i_r1 = $i_r1;
        $this->i_r2 = $i_r2;
        $this->i_r4 = $i_r4;
        $this->e_r1 = $e_r1;
        $this->e_r2 = $e_r2;
        $this->e_r4 = $e_r4;
    }


    // public static function getLast()
    // {
    //     $db = Database::getInstance()->getConnection();
    //     //$stmt = $db->query("SELECT id,name FROM users");
    //     $stmt = $db->query("SELECT * FROM data ORDER BY id DESC LIMIT 1");
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    public static function getLast()
    {
        $db = Database::getInstance()->getConnection();
        //$stmt = $db->query("SELECT id,name FROM users");
        //$stmt = $db->query("SELECT * FROM data ORDER BY id DESC LIMIT 1");
        //$stmt = $db->query("SELECT * FROM data ORDER BY id DESC LIMIT 1");

        //$stmt = $db->query("SELECT c.customer_name, o.order_id FROM customers c INNER JOIN orders o ON o.customer_id = c.id ORDER BY o.id desc LIMIT 1");

        //$stmt = $db->query("SELECT v.s_sc, v.t_r1 FROM data v JOIN github g ORDER BY v.id desc LIMIT 1");

        $stmt = $db->query("
            SELECT
                v.s_ts,
                v.s_pr,
                v.s_ng,
                v.s_dg,
                v.s_cn,
                v.s_op,
                v.s_sc,
                v.t_r0,
                v.t_r1,
                v.t_r2,
                v.t_r4,
                v.h_r0,
                v.h_r1,
                v.h_r2,
                v.h_r4,
                v.c_r1,
                v.c_r2,
                v.c_r4,
                v.a_r1,
                v.a_r2,
                v.a_r4,
                v.i_r1,
                v.i_r2,
                v.i_r4,
                v.e_r1,
                v.e_r2,
                v.e_r4,
                g.status_indicator AS w_gh
            FROM
                data v, github g
            ORDER BY
                v.id, g.id DESC LIMIT 1
        ");



        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getOpenState()
    {
        $db = Database::getInstance()->getConnection();
        //$stmt = $db->query("SELECT id,name FROM users");
        $stmt = $db->query("SELECT s_op FROM data ORDER BY id DESC LIMIT 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function save()
    {
        $db = Database::getInstance()->getConnection();
        //$stmt = $db->prepare("INSERT INTO users (name) VALUES (:name)");
        //$stmt = $db->prepare("INSERT INTO data (s_ts, s_pr, s_ng, s_dg, s_cn, s_op, s_sc, t_r0, t_r1, t_r2, t_r4, h_r0, h_r1, h_r2, h_r4, c_r1, c_r2, c_r4, a_r1, a_r2, a_r4, i_r1, i_r2, i_r4, e_r1, e_r2, e_r4) VALUES (:s_ts, :s_pr, :s_ng, :s_dg, :s_cn, :s_op, :s_sc, :t_r0, :t_r1, :t_r2, :t_r4, :h_r0, :h_r1, :h_r2, :h_r4, :c_r1, :c_r2, :c_r4, :a_r1, :a_r2, :a_r4, :i_r1, :i_r2, :i_r4, :e_r1, :e_r2, :e_r4)");
        $stmt = $db->prepare("
            INSERT INTO data (
                s_ts,
                s_pr,
                s_ng,
                s_dg,
                s_cn,
                s_op,
                s_sc,
                t_r0,
                t_r1,
                t_r2,
                t_r4,
                h_r0,
                h_r1,
                h_r2,
                h_r4,
                c_r1,
                c_r2,
                c_r4,
                a_r1,
                a_r2,
                a_r4,
                i_r1,
                i_r2,
                i_r4,
                e_r1,
                e_r2,
                e_r4
            ) VALUES (
                :s_ts,
                :s_pr,
                :s_ng,
                :s_dg,
                :s_cn,
                :s_op,
                :s_sc,
                :t_r0,
                :t_r1,
                :t_r2,
                :t_r4,
                :h_r0,
                :h_r1,
                :h_r2,
                :h_r4,
                :c_r1,
                :c_r2,
                :c_r4,
                :a_r1,
                :a_r2,
                :a_r4,
                :i_r1,
                :i_r2,
                :i_r4,
                :e_r1,
                :e_r2,
                :e_r4
            )
        ");

        
        $stmt->bindParam(':s_ts', $this->s_ts);
        $stmt->bindParam(':s_pr', $this->s_pr);
        $stmt->bindParam(':s_ng', $this->s_ng);
        $stmt->bindParam(':s_dg', $this->s_dg);
        $stmt->bindParam(':s_cn', $this->s_cn);
        $stmt->bindParam(':s_op', $this->s_op);
        $stmt->bindParam(':s_sc', $this->s_sc);
        $stmt->bindParam(':t_r0', $this->t_r0);
        $stmt->bindParam(':t_r1', $this->t_r1);
        $stmt->bindParam(':t_r2', $this->t_r2);
        $stmt->bindParam(':t_r4', $this->t_r4);
        $stmt->bindParam(':h_r0', $this->h_r0);
        $stmt->bindParam(':h_r1', $this->h_r1);
        $stmt->bindParam(':h_r2', $this->h_r2);
        $stmt->bindParam(':h_r4', $this->h_r4);
        $stmt->bindParam(':c_r1', $this->c_r1);
        $stmt->bindParam(':c_r2', $this->c_r2);
        $stmt->bindParam(':c_r4', $this->c_r4);
        $stmt->bindParam(':a_r1', $this->a_r1);
        $stmt->bindParam(':a_r2', $this->a_r2);
        $stmt->bindParam(':a_r4', $this->a_r4);
        $stmt->bindParam(':i_r1', $this->i_r1);
        $stmt->bindParam(':i_r2', $this->i_r2);
        $stmt->bindParam(':i_r4', $this->i_r4);
        $stmt->bindParam(':e_r1', $this->e_r1);
        $stmt->bindParam(':e_r2', $this->e_r2);
        $stmt->bindParam(':e_r4', $this->e_r4);
        $stmt->execute();
    }

}
