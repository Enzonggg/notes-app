<?php

namespace App\Controllers;

use App\Models\NoteModel;

class Notes extends BaseController
{
    public function list()
    {
        // Set JSON response header
        $this->response->setHeader('Content-Type', 'application/json');
        
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }
        
        $noteModel = new NoteModel();
        $userId = session()->get('user_id');
        
        $notes = $noteModel->where('user_id', $userId)
                          ->orderBy('created_at', 'DESC')
                          ->findAll();
        
        return $this->response->setJSON([
            'success' => true,
            'notes' => $notes
        ]);
    }

    public function create()
    {
        // Set JSON response header
        $this->response->setHeader('Content-Type', 'application/json');
        
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }
        
        $noteModel = new NoteModel();
        $json = $this->request->getJSON();
        
        $data = [
            'user_id' => session()->get('user_id'),
            'title' => $json->title ?? '',
            'content' => $json->content ?? '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if (empty($data['title']) || empty($data['content'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Title and content are required'
            ]);
        }
        
        if ($noteModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Note created successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to create note'
            ]);
        }
    }

    public function update()
    {
        // Set JSON response header
        $this->response->setHeader('Content-Type', 'application/json');
        
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }
        
        $noteModel = new NoteModel();
        $json = $this->request->getJSON();
        
        $noteId = $json->id ?? null;
        $userId = session()->get('user_id');
        
        // Verify note belongs to user
        $note = $noteModel->where('id', $noteId)
                         ->where('user_id', $userId)
                         ->first();
        
        if (!$note) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Note not found'
            ]);
        }
        
        $data = [
            'title' => $json->title ?? $note['title'],
            'content' => $json->content ?? $note['content'],
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        if ($noteModel->update($noteId, $data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Note updated successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update note'
            ]);
        }
    }

    public function delete()
    {
        // Set JSON response header
        $this->response->setHeader('Content-Type', 'application/json');
        
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }
        
        $noteModel = new NoteModel();
        $json = $this->request->getJSON();
        
        $noteId = $json->id ?? null;
        $userId = session()->get('user_id');
        
        // Verify note belongs to user
        $note = $noteModel->where('id', $noteId)
                         ->where('user_id', $userId)
                         ->first();
        
        if (!$note) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Note not found'
            ]);
        }
        
        if ($noteModel->delete($noteId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Note deleted successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete note'
            ]);
        }
    }
}
