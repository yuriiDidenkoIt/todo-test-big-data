import React, { useState } from "react";
import classNames from 'classnames';
import CheckboxCompleted from "./Atoms/CheckboxCompleted";
import InputText from "./Atoms/InputText";
import useUpdateTodo from "../hooks/useUpdateTodo";
import useDeleteTodo from "../hooks/useDeleteTodo";
import { VISIBILITY_FILTERS, VISIBILITY_FILTERS_IDS } from "../constants";

import './Todo.css';

const Todo = ({ todo, todoIndex }) => {
    const [isSending, updateTodo] = useUpdateTodo()
    const [isDeleting, deleteTodo] = useDeleteTodo()
    const [isEditing, setIsEditing] = useState(false)
    const [title, setTitle] = useState(todo.title);

    const toggleStatus = () => {
        const statusId = [
            VISIBILITY_FILTERS_IDS.NEW,
            VISIBILITY_FILTERS_IDS.REJECTED,
            VISIBILITY_FILTERS_IDS.IN_PROGRESS
        ].includes(todo.statusId) ? VISIBILITY_FILTERS_IDS.COMPLETED : VISIBILITY_FILTERS_IDS.NEW;
        updateTodo(todo.id, todoIndex, { statusId });
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
                checked={+todo.statusId === 2}
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
                {VISIBILITY_FILTERS[todo.statusId]}
            </div>
            <div className="todo-likes">
                {todo.likesCount}
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