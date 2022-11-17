<?php
App::uses('AppController', 'Controller');
/**
 * Peliculas Controller
 *
 * @property Pelicula $Pelicula
 * @property PaginatorComponent $Paginator
 */
class PeliculasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Pelicula->recursive = 0;
		//Si se busca campo displayField del modelo
		$campo = !empty($this->Pelicula->displayField)?$this->Pelicula->displayField:'id';
		$this->set('campo',$campo);
		if (!empty($this->request->query[$campo])){	    
		    $nombre = $this->request->query[$campo];
			$this->request->data['Pelicula'][$campo] = $nombre ;
			$conditions = array('conditions' => array('Pelicula.'.$campo.' LIKE' => '%'.$nombre.'%'));
			$this->Paginator->settings = array_merge($this->Paginator->settings,$conditions);
		}
		$this->set('peliculas', $this->Paginator->paginate());
	}
	
	public function index2() {
	    $Peliculas = $this->Pelicula->find('all');
	    $Peliculas = Set::extract($Peliculas, '{n}.Pelicula');
	    //pr($Personas);
	    $this->set(array(
	        'Peliculas' => $Peliculas,
	        '_serialize' => array('Peliculas')
	    ));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Pelicula->exists($id)) {
			throw new NotFoundException(__('Invalid pelicula'));
		}
		$options = array('conditions' => array('Pelicula.' . $this->Pelicula->primaryKey => $id));
		$this->set('pelicula', $this->Pelicula->find('first', $options));
	}
	
	public function view2($id) {
	    $Pelicula = $this->Pelicula->findById($id);
	    $Pelicula = Set::extract($Pelicula, 'Pelicula');
	    $this->set(array(
	        'Pelicula' => $Pelicula,
	        '_serialize' => array('Pelicula')
	    ));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Pelicula->create();
			if ($this->Pelicula->save($this->request->data)) {
				$this->Flash->success(__('The pelicula has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The pelicula could not be saved. Please, try again.'));
			}
		}
	}
	
	public function add2() {
	    //pr($this->request->data);
	    $this->Pelicula->create();
	    if ($this->Pelicula->save($this->request->data)) {
	        $message = 'Guardado';
	    } else {
	        $message = 'Error';
	    }
	    $this->set(array(
	        'message' => $message,
	        '_serialize' => array('message')
	    ));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Pelicula->exists($id)) {
			throw new NotFoundException(__('Invalid pelicula'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Pelicula->save($this->request->data)) {
				$this->Flash->success(__('The pelicula has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The pelicula could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Pelicula.' . $this->Pelicula->primaryKey => $id));
			$this->request->data = $this->Pelicula->find('first', $options);
		}
	}
	
	public function edit2($id) {
	    $this->Pelicula->id = $id;
	    if ($this->Pelicula->save($this->request->data)) {
	        $message = 'Actualizar';
	    } else {
	        $message = 'Error';
	    }
	    $this->set(array(
	        'message' => $message,
	        '_serialize' => array('message')
	    ));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Pelicula->id = $id;
		if (!$this->Pelicula->exists()) {
			throw new NotFoundException(__('Invalid pelicula'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Pelicula->delete()) {
			$this->Flash->success(__('The pelicula has been deleted.'));
		} else {
			$this->Flash->error(__('The pelicula could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	public function delete2($id) {
	    if ($this->Pelicula->delete($id)) {
	        $message = 'Eliminado';
	    } else {
	        $message = 'Error';
	    }
	    $this->set(array(
	        'message' => $message,
	        '_serialize' => array('message')
	    ));
	}
}
