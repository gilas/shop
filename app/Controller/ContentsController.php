<?php

App::uses('AppController', 'Controller');

/**
 * Content Controller
 *
 * @property Content $Content
 */
class ContentsController extends AppController {

    public $paginateConditions = array(
        'title' => array(
            'type' => 'LIKE',
            'field' => array(
                'Content.intro',
                'Content.title',
                'Content.content',
            ),
        ),
        'published' => array('field' => 'Content.published'),
        'frontpage' => array('field' => 'Content.frontpage'),
        'allow_comment' => array('field' => 'Content.allow_comment'),
        'content_category_id' => array('field' => 'Content.content_category_id'),
        'user' => array(
            'type' => 'LIKE',
            'field' => 'User.name',
        ),
    );
    public $components = array('RequestHandler');
    public $paginate = array('order' => 'Content.lft DESC',);
    private $__readMore = '<hr id="system-readmore" />';
    public $publicActions = array(
        'search',
        'home',
        'category',
        'archive',
        'view',
        'latestContents',
        'viewArticles',
    );

    public function admin_index() {
        $this->pageTitle = 'مدیریت مطالب';
        $contents = $this->paginate();
        // Check the item can move to up or down
        $this->_recognizeMoving($contents, 'Content');

        for ($i = 0; $i < count($contents); $i++) {
            $contents[$i]['Content']['commentCount'] = $this->Content->Comment->find('count', array('conditions' => array('content_id' => $contents[$i]['Content']['id'])));
        }
        // add this helper for using FilterHelper in Filter Form
        $this->helpers[] = 'AdminForm';
        $this->set('contentCategories', $this->Content->ContentCategory->
                        generateTreeList());
        $this->set(compact('contents'));
    }

    public function admin_add() {
        $this->helpers[] = 'TinyMCE.TinyMCE';
        $this->pageTitle = 'افزودن مطلب';
        $contentCategories = $this->Content->ContentCategory->generateTreeList();
        $contentCategories [0] = '--- بدون مجموعه ---';
        $this->set('contentCategories', $contentCategories);
        if ($this->request->is('post')) {

            $full_content = explode($this->__readMore, $this->request->data['Content']['intro']);
            $this->request->data['Content']['intro'] = $full_content[0];
            if (!empty($full_content[1])) {
                $this->request->data['Content']['content'] = $full_content[1];
            } else {
                $this->request->data['Content']['content'] = null;
            }

            $this->request->data['Content']['user_id'] = $this->Auth->user('id');
            if (!empty($this->request->data['Content']['slug']))
                $this->request->data['Content']['slug'] = Inflector::slug($this->request->data['Content']['slug']);
            else
                $this->request->data['Content']['slug'] = Inflector::slug($this->request->data['Content']['title']);

            if ($this->Content->save($this->request->data)) {
                $this->Session->setFlash('مطلب با موفقیت ذخیره شد.', 'message', array('type' =>
                    'success'));
                $this->redirect(array('action' => 'index', 'admin' => true));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
                $this->request->data['Content']['intro'] = $full_content[0];
                if (!empty($full_content[1])) {
                    $this->request->data['Content']['intro'] .= $this->__readMore . $full_content[1];
                }
            }
        }
    }

    public function admin_delete() {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException(SettingsController::read('Error.Code-12'));
        }

        $id = $this->request->data['id']; // we recieve id via posted data
        $count = count($id);
        if ($count == 1) {
            $id = current($id);
            $this->Content->id = $id;

            if ($this->Content->delete()) {
                $this->Session->setFlash('مطلب با موفقیت حذف شد.', 'message', array('type' =>
                    'success'));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-16'), 'message', array('type' => 'error'));
            }
        } elseif ($count > 1) {
            $countAffected = 0;
            foreach ($id as $i) {
                $this->Content->id = $i;
                if ($this->Content->delete()) {
                    $countAffected++;
                }
            }
            $this->Session->setFlash($countAffected . ' مطلب با موفقیت حذف شد.', 'message', array('type' => 'success'));
        }
        $this->redirect($this->referer());
    }

    public function admin_edit($id = null) {
        $this->helpers[] = 'TinyMCE.TinyMCE';
        $this->pageTitle = 'ویرایش مطلب';
		$contentCategories = $this->Content->ContentCategory->generateTreeList();
		$contentCategories[0] = '--- بدون مجموعه ---';
        $this->set('contentCategories', $contentCategories);

        $this->Content->id = $id;
        if (!$this->Content->exists()) {
            throw new NotFoundException(SettingsController::read('Error.Code-14'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            $full_content = explode($this->__readMore, $this->request->data['Content']['intro']);
            $this->request->data['Content']['intro'] = $full_content[0];
            if (!empty($full_content[1])) {
                $this->request->data['Content']['content'] = $full_content[1];
            } else {
                $this->request->data['Content']['content'] = null;
            }

            if (!empty($this->request->data['Content']['slug']))
                $this->request->data['Content']['slug'] = Inflector::slug($this->request->data['Content']['slug']);
            else
                $this->request->data['Content']['slug'] = Inflector::slug($this->request->data['Content']['title']);
            if ($this->Content->save($this->request->data)) {
                $this->Session->setFlash('مطلب با موفقیت ویرایش شد.', 'message', array('type' =>
                    'success'));
                $this->redirect(array('action' => 'index', 'admin' => true));
            } else {
                $this->Session->setFlash(SettingsController::read('Error.Code-13'), 'message', array('type' => 'error'));
            }
        } else {
            $this->request->data = $this->Content->read();
        }
        $content = $this->request->data['Content']['intro'];
        if (!empty($this->request->data['Content']['content'])) {
            $this->request->data['Content']['intro'] = $content . $this->__readMore . $this->
                    request->data['Content']['content'];
        } else {
            $this->request->data['Content']['intro'] = $content;
        }
        $this->render('admin_add');
    }

    public function admin_move() {
        $this->_move('Content', 'مطلب با موفقیت ویرایش شد.');
        $this->redirect($this->referer());
    }

    public function admin_publish() {
        $this->_changeStatus('Content', 'published', 1, 'مطلب با موفقیت منتشر شد.');
        $this->redirect($this->referer());
    }

    public function admin_unPublish() {
        $this->_changeStatus('Content', 'published', 0, 'مطلب با موفقیت از حالت انتشار خارج شد.');
        $this->redirect($this->referer());
    }

    public function admin_addToFrontPage() {
        $this->_changeStatus('Content', 'frontpage', 1, 'مطلب با موفقیت به صفحه اصلی اضافه شد.');
        $this->redirect($this->referer());
    }

    public function admin_removeFromFrontPage() {
        $this->_changeStatus('Content', 'frontpage', 0, 'مطلب با موفقیت از صفحه اصلی حذف شد.');
        $this->redirect($this->referer());
    }

    public function admin_allowComment() {
        $this->_changeStatus('Content', 'allow_comment', 1, 'نظر دهی به مطلب با موفقیت فعال شد.');
        $this->redirect($this->referer());
    }

    public function admin_disallowComment() {
        $this->_changeStatus('Content', 'allow_comment', 0, 'نظر دهی به مطلب با موفقیت غیرفعال شد.');
        $this->redirect($this->referer());
    }

    public function admin_getLinkItem() {

        $conditions = array('Content.published' => true);
        if (!empty($this->request->query['q'])) {
            $conditions['Content.title LIKE'] = "%{$this->request->query['q']}%";
        }
        $this->paginate['conditions'] = $conditions;
        $this->paginate['limit'] = 10;
        $this->paginate['contain'] = 'ContentCategory';
        $this->set('contents', $this->paginate());
    }

    /**
     * Search in Contents
     *
     * @param mixed $q
     * @return void
     */
    public function search($q = null) {
        $q = (isset($this->request->query['q'])) ? $this->request->query['q'] : $q;
        $conditions = array(
            'conditions' => array(
                'OR' => array(
                    "Content.intro LIKE" => "%$q%",
                    "Content.content LIKE" => "%$q%",
                    "Content.title LIKE" => "%$q%",
                    "ContentCategory.name LIKE" => "%$q%",
                ),
                "ContentCategory.access" => 0, // search only in public articles
            ),
        );
        //for pagination link
        $this->set('pastAction', $this->action);
        // fetch content by this action and sent conditions
        $this->setAction('listArticles', $conditions);
    }

    /**
     * Show contents that can showing in frontpage
     *
     * @return void
     */
    public function home() {
        //for pagination link
        $this->set('pastAction', $this->action);
        $conditions = array('conditions' => array('Content.frontpage' => true),);
        // fetch content by this action and sent conditions
        $this->setAction('listArticles', $conditions);
    }

    /**
     * Show contents via category
     *
     * @param mixed $id
     * @return
     */
    public function category($id = null) {
        // Show content for this id
        if ($id) {
            //read category info
            $category = $this->Content->ContentCategory->find('first', array(
                'conditions' => array(
                    'id' => $id,
                    'published' => true,
                ),
                'contain' => false,
                    ));

            // read path
            $categories = $this->Content->ContentCategory->getPath($category['ContentCategory']['id']);
            $this->set(compact('categories'));
            //for pagination link
            $this->set('pastAction', $this->action);

            // fetch content by this action and sent conditions
            $this->setAction('listArticles', array('conditions' => array('Content.content_category_id' =>
                    $category['ContentCategory']['id'])));
            return;
        }
        $this->redirect('/');
        // if no id so show all categories
        $categories = $this->Content->ContentCategory->find('all', array('conditions' =>
            array('ContentCategory.published' => true,),));
        $this->set('categories', $categories);
    }

    public function archive($year = null, $month = null) {
        if (!$year) {
            throw new NotFoundException(SettingsController::read('Error.Code-12'));
        }
        if ($year) {
            $date = "$year-";
            if ($month) {
                $date .= "$month-%";
            } else {
                $date .= "%";
            }
            //for pagination link
            $this->set('pastAction', $this->action);

            // fetch content by this action and sent conditions
            $this->setAction('listArticles', array('conditions' => array('Content.created LIKE' =>
                    $date)));
            return;
        }
    }

    /**
     * List Contents , This action cann't access directly from url
     * and used from other actions by passing $conditions to it
     *
     * @param array $conditions : Conditions of Contents that must show
     * @return null
     */
    public function listArticles($conditions = array()) {
        $this->pageTitle =  'مطالب';
        $this->paginate['conditions']['Content.published'] = true;
        // Don't show locked files
        $this->paginate['conditions'][] = 'ContentCategory.is_lock IS NULL';
        $this->paginate['contain'] = array('User', 'ContentCategory');
        $this->paginate['limit'] = SettingsController::read('Content.count');
        $this->paginate = Set::merge($this->paginate, $conditions);
        // RSS
        if ($this->RequestHandler->isRss()) {
            $contents = $this->Content->find('all', $this->paginate);
            $this->set(compact('contents'));
            return;
        }

        //cann't access directly to this action
        if (empty($this->viewVars['pastAction'])) {
            throw new NotFoundException();
        }
        $contents = $this->paginate();
        if ($contents) {
            foreach ($contents as &$content) {
                $content['countComment'] = $this->Content->Comment->find('count', array(
                    'conditions' => array('published' => true, 'content_id' => $content['Content']['id']),
                    'contain' => false,
                        ));
            }
        }
        $this->set(compact('contents'));
    }

    /**
     * View Content for gived $id
     *
     * @param int $id : ID of content that must be show
     * @return null
     */
    public function view($id = null) {
        $conditions = array('Content.id' => $id, 'Content.published' => true);
        $content = $this->Content->find('first', array('conditions' => $conditions));

        if (!$content) {
            throw new NotFoundException('مطلب یافت نشد');
        }

        $this->set('content', $content);
        $this->set('comments', $this->Content->Comment->find('all', array(
                    'conditions' => array('Comment.content_id' => $id, 'Comment.published' => '1'),
                    'contain' => false,
                )));
        $categories = $this->Content->ContentCategory->getPath($content['Content']['content_category_id']);
        $this->set('categories', $categories);

        if ($this->request->isPost()) {
            App::uses('CommentsController', 'Controller');
            $commentObj = new CommentsController();
            $commentObj->constructClasses();
            $success = $commentObj->add_comment($this->request->data, $content['Content']['id'], $content['Content']['published_comment']);
            switch($success){
                case 1:
                    $this->Session->setFlash('نظر با موفقیت افزوده شد.', 'message', array('type' => 'success'));
                    break;
                case 2:
                    $this->Session->setFlash('نظر با موفقیت افزوده شد ولی برای نمایش ابتدا باید به تایید مدیریت برسد!', 'message', array('type' => 'success'));
                    break;
                default:
                    $this->Session->setFlash('امکان درج نظر وجود ندارد', 'message', array('type' => 'error'), 'comment');
            }
        }
    }

    public function latestContents() {
        $this->helpers = array('Text');
        $contents = $this->Content->find('all', array(
            'fields' => array(
                'Content.id',
                'Content.title',
                'Content.slug'),
            'recursive' => '-1',
            'order' => array(
                'Content.lft DESC'),
            'limit' => '5',
            'conditions' => array(
                'Content.published' => '1',
                'Content.content_category_id' => '> 0'
            )
                ));
        $this->set('contents', $contents);
    }

    protected function _canEdit($id){
        $this->Content->recursive = -1;
        $category = $this->Content->read(null, $id);
        if($this->Auth->user('Role.name') == 'Register' and $category['Content']['user_id'] != $this->Auth->user('id')){
            $this->Session->setFlash('مطلب موردنظر غیرقابل ویرایش است', 'message', array('type' => 'warning'));
            return false;
        }
        return true;
    }

    public function viewArticles(){
        //for pagination link
        $this->set('pastAction', $this->action);
        $conditions = array(
        'conditions' => array(
            'Content.user_id' => $this->request['ProfileUserID'],
            'ContentCategory.id <>' => 1,
            ),
        );
        // fetch content by this action and sent conditions
        $this->setAction('listArticles', $conditions);
    }

    protected function _checkAuth($key){
        if(! SettingsController::read($key)){
            $this->Auth->flash($this->Auth->authError);
            $this->redirect($this->referer());
        }
     }

     /**
 * Move content form one category to another
 *
 *
 * @return void
 */
    public function admin_moveToCategory(){
        // get $cat_id
        $cat_id = $this->request->data['cat_id'];

        // the contents can has no any category , so the 'name' of it is بدون مجموعه and 'id' of it is zero
        $cat_name = 'بدون مجموعه';

        if($cat_id !== '0'){
            $this->Content->ContentCategory->id = $cat_id;
            // Check the category is exists
            if(! $this->Content->ContentCategory->exists()){
                $this->Session->setFlash('مجموعه مورد نظر معتبر نمی باشد.','alert',array('type' => 'error'));
                $this->redirect($this->referer());
            }
        }
        // read info of ContentCategory
        $this->Content->ContentCategory->recursive = -1;
        $category = $this->Content->ContentCategory->read();
        if(! empty($category)){
            // Set $cat_name
            $cat_name = $category['ContentCategory']['name'];
        }

        //Change content_category_id of content to current $cat_id
        $this->_changeStatus('Content', 'content_category_id', $cat_id, 'مطلب با موفقیت به مجموعه ('.$cat_name.') منتقل گردید.');

        $this->redirect($this->referer());
    }
}

?>
