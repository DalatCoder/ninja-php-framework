<?php

namespace Ninja;

interface IController
{
    public function index() : array;
    public function show() : array;
    public function create() : array;
    public function store() : void;
    public function edit() : array;
    public function update() : void;
    public function destroy() : void;
}
