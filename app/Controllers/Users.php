<?php

namespace App\Controllers;

use App\Models\User;

use CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController
{
    private $db;
    public function __construct()
    {
        $this->db = db_connect();
    }
    public function new()
    {
        return view('new_user');
    }
    public function create()
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age')
        ];

        $image = $this->request->getFile('image'); 
        if ($image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName(); 
            $image->move('uploads', $newName); 
            $data['image'] = $newName;
        }

        $result = $this->db->table('users')->insert($data);

        $status = ($result) ? 'Record has been inserted :)' : 'Record has not been inserted :(';

        return redirect()->to(base_url('users'))->with('status', $status);
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $users = $this->db->table('users')->get()->getResult();
        
        $data['users'] = $users;

        return view('read_users', $data);
    }

    public function edit($id = null)
    {
        $user = $this->db->table('users')->getWhere(['id' => $id], 1)->getRow();
        $data['user'] = $user;

        return view('update_form', $data);
    }
    public function update($id = null)
    {
        $user = new User();
    
        $data = [
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age'),
        ];
    
        $newImage = $this->request->getFile('image');
    
        if ($newImage->isValid() && !$newImage->hasMoved()) {
            $newImageName = $newImage->getRandomName();
            $newImage->move('uploads', $newImageName);
            $data['image'] = $newImageName; 
            // dd($newImageName);
            $userToUpdate = $user->find($id);
            if (!empty($userToUpdate['image'])) {
                if(file_exists('uploads/' . $userToUpdate['image'])){
                    unlink('uploads/' . $userToUpdate['image']); 
                }
            }
        }
        $builder = $this->db->table('users');
        $builder->set($data);
        $builder->where('id', $id);
        $result = $builder->update();    
        $status = ($result) ? 'Record has been updated :)' : 'Record has not been updated :(';
    
        return redirect()->to(base_url('users'))->with('status', $status);
    }
    

    public function delete($id = null)
{
    $user = new User();

    $userToDelete = $user->find($id);

    if ($userToDelete) {
        $result = $user->delete($id);

        if ($result) {
            if (!empty($userToDelete['image'])) {
                $imagePath = 'uploads/' . $userToDelete['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath); 
                }
            }

            $status = 'Record has been deleted :)';
        } else {
            $status = 'Record has not been deleted :(';
        }
    } else {
        $status = 'User not found :(';
    }

    return redirect()->to(base_url('users'))->with('status', $status);
}

}

