import React from "react";
import { useSelector } from "react-redux";
import { getTodos } from "../redux/selectors";
import Todo from "./Todo";
import useLoadTodosFromServer from "../hooks/useLoadTodosFromServer";

import './TodoList.css'
import Spinner from "./Atoms/Spinner";

const TodoList = () => {
    const isLoading = useLoadTodosFromServer();
    const todos = useSelector(getTodos);

    if (isLoading) {
        return <Spinner />;
    }

    if (!todos || !todos.length) {
        return <div className="todo-item-container"> 'OOpsss , probably you are to busy to do something'</div>
    }

    return (
        <>
            {todos.map((todo, index) => <Todo todoIndex={index} key={`todo-${todo.id}`} todo={todo}/>)}
        </>
    );
}

export default TodoList;