import React, { useState } from 'react';
import './TodoAdd.css'
import InputText from "./Atoms/InputText";
import useAddTodo from "../hooks/useAddTodo";

const TodoAdd = () => {
    const [value, setValue] = useState('');
    const [isSending, addTodo] = useAddTodo();
    const createTodo = async (event) => {
        event.preventDefault();
        addTodo(value, () => setValue(''));
    }

    return (
        <form onSubmit={createTodo} className="todo-add">
            {/*<CheckboxCompleted name="todoAdd" checked={checked} onClick={() => {}}/>*/}
            <InputText
                onChange={(event) => setValue(event.target.value)}
                value={value}
            />
        </form>
    )
}

export default TodoAdd;