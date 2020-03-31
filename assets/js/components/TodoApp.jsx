import React from 'react';
import TodoList from './TodoList';
import VisibilityFilters from './VisibilityFilters';
import Pagination from "./Pagination";
import TodoAdd from './TodoAdd';
import OrderByLikes from './OrderByLikes';

import './TodoApp.css';

const TodoApp = () => {
    return (
        <div className="todo-app">
            <h1>Todo List</h1>
            <VisibilityFilters/>
            <OrderByLikes/>
            <TodoAdd/>
            <TodoList/>
            <Pagination/>
        </div>
    )
};

export default TodoApp;