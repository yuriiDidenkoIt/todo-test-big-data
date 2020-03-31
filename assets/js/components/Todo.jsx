import React, { useState } from "react";
import classNames from 'classnames';
import CheckboxCompleted from "./Atoms/CheckboxCompleted";
import InputText from "./Atoms/InputText";
import useUpdateTodo from "../hooks/useUpdateTodo";
import useDeleteTodo from "../hooks/useDeleteTodo";
import { VISIBILITY_FILTERS } from "../constants";

import './Todo.css';

const Todo = ({ todo, todoIndex }) => {
    const [isSending, updateTodo] = useUpdateTodo()
    const [isDeleting, deleteTodo] = useDeleteTodo()
    const [isEditing, setIsEditing] = useState(false)
    const [title, setTitle] = useState(todo.title);

    const toggleStatus = () => {
        const status = [
            VISIBILITY_FILTERS.NEW,
            VISIBILITY_FILTERS.REJECTED,
            VISIBILITY_FILTERS.IN_PROGRESS
        ].includes(todo.status) ? VISIBILITY_FILTERS.COMPLETED : VISIBILITY_FILTERS.NEW;
        updateTodo(todo.id, todoIndex, { status });
    }

    const updateTitle = (event) => {
        event.preventDefault();
        updateTodo(todo.id, todoIndex, { title }, () => setIsEditing(false));
    }

    return (
        <div className="todo-item-container">
            <CheckboxCompleted
                isDisabled={isSending}
                name={todo.id}
                checked={todo.status === 'completed'}
                onClick={toggleStatus}
            />
            <div className={classNames('todo-title', { hidden: isEditing })} onDoubleClick={() => setIsEditing(true)}>
                {todo.title}
            </div>
            <form
                className={classNames('todo-title-edit', { hidden: !isEditing })}
                onSubmit={updateTitle}
            >
                <InputText
                    onMouseLeave={() => setIsEditing(false)}
                    onChange={(event) => setTitle(event.target.value)}
                    value={title}
                />
            </form>
            <div className="todo-status">
                {todo.status}
            </div>
            <div className="todo-likes">
                {todo.likes_count}
            </div>
            <div
                className="todo-delete"
                onClick={() => deleteTodo(todo.id, todoIndex)}
            >
                DELETE
            </div>
        </div>
    );
}
export default Todo;