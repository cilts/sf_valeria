<?php

namespace Admin\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * user
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Admin\UserBundle\Repository\userRepository")
 */
class user
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var nome
     *
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var email
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var senha
     *
     * @ORM\Column(name="senha", type="string", length=255)
     */
    private $senha;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param nome $nome
     *
     * @return user
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set email
     *
     * @param email email
     *
     * @return email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set senha
     *
     * @param senha senha
     *
     * @return senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get senha
     *
     * @return senha
     */
    public function getSenha()
    {
        return $this->senha;
    }
}
