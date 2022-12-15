<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {

		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('index');
	}

	public function inscreverse() {

		$this->view->usuario = array(
			'nome' => '',
			'email' => '',
			'senha' => '',
		);

		$this->view->erroCadastro = false;

		$this->render('inscreverse');
	}

	public function registrar() {

		//receber os dados do formulário
		$usuario = Container::getModel('Usuario');

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('nome', $_POST['email']);
		$usuario->__set('nome', ($_POST['senha']));

		if($usuario->validarCadastro()) {
			if(count($usuario->getUsuarioPorEmail()) > 0) {
				$this->view->usuario = array(
					'nome' => $_POST['nome'],
					'senha' => $_POST['senha'],
				);
				$this->view->erroCadastro = 2;
				$this->render('inscreverse');
			} else {
				$usuario->__set('senha', md5($_POST['senha']));
				$usuario->salvar();
				$this->render('cadastro');
			}

		} else {

			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha'],
			);

			$this->view->erroCadastro = 1;
			
			$this->render('inscreverse');
		}

	}

}


?>