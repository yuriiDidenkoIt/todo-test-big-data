import React, { useState } from 'react';
import InputText from "./Atoms/InputText";
import useAddTodo from "../hooks/useAddTodo";

import './TodoAdd.css'

const TodoAdd = () => {
    const [value, setValue] = useState('');
    const [isSending, addTodo] = useAddTodo();
    const createTodo = async (event) => {
        event.preventDefault();
        addTodo(value, () => setValue(''));
    }

    return (
        <form onSubmit={createTodo} className="todo-add">
            <InputText
                onChange={(event) => setValue(event.target.value)}
                value={value}
            />
        </form>
    )
}

export default TodoAdd;