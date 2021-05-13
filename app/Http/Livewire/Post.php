<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Posts;

class Post extends Component
{
    public $posts, $title, $body, $slug;
    public $isModalOpen = 0;


    public function render()
    {
        $this->posts=Posts::all();

        return view('livewire.post');
    }

    public function create(){
        $this->resetForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }
    
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    public function resetForm(){
        $this->title='';
        $this->body='';
        $this->slug='';
    }

    public function store(){
        $this->validate([
            'title' => 'required',
            'body' => 'requuired',
            'slug' => 'required',
        ]);

        Post::updateOrCreate([
            'id'=>$this->post_id],
            [
                'title'  => $this->title,
                'body'   => $this->body,
                'slug'   => $this->slug,
            ]);
            session()->flash('message', $this->post_id ? 'Post updated' : 'Post created');

            $this->closeModalPopover();
            $this->resetForm();
    }
    public function edit($id) {
        $post = Post::findOrFail($id);
        $this->id = $id;
        $this->title = $post->title;
        $this->body = $post->body;
        $this->slug = $post->slug;

        $this->openModalPopover();

    }

    public function delete($id){
        Post::find($id)->delete();
        session()->flash('message', 'Message deleted Successfully');
    }


}
