import { useState, useEffect, useRef } from 'react';
import { batch, useDispatch, useSelector } from 'react-redux';
import axios from "axios";
import { getActiveOrderByLikes, getActivePage, getLastTodoByActivePage, getVisibilityFilter } from "../redux/selectors";
import { reorderTodos, updateTotalItemsCount } from "../redux/actions";
import { VISIBILITY_FILTERS } from "../constants";

export default () => {
    const [isSending, setIsSending] = useState(false);
    const isMounted = useRef(null);
    const lastTodo = useSelector(getLastTodoByActivePage);
    const activePage = useSelector(getActivePage);
    const visibilityFilter = useSelector(getVisibilityFilter);
    const orderByLikes = useSelector(getActiveOrderByLikes);
    const dispatch = useDispatch();

    const deleteTodo = (todoId, todoIndex) => {
        const params = new URLSearchParams();
        params.append('prevId', lastTodo.id);
        params.append('prevLikesCount', lastTodo.likes_count);
        params.append('orderByLikes', orderByLikes);
        params.append('status', visibilityFilter === VISIBILITY_FILTERS.ALL ? '' : visibilityFilter);
        params.append('limit', 1);

        axios.delete(`/api/todos/${todoId}`, {data: params})
            .then((response) => {
                setIsSending(false);
                batch(() => {
                    dispatch(reorderTodos(response.data.lastTodo, todoIndex, activePage))
                    dispatch(updateTotalItemsCount(response.data.totalItemsCount[visibilityFilter]))
                })
            })
            .catch((error) => {
                // todo : should be popup for error message
                console.log(error);
            })
            .finally(() => {
                if (isMounted.current) {
                    setIsSending(false);
                }
            });
    }

    useEffect(() => {
        isMounted.current = true;
        return () => {
            isMounted.current = false;
        };
    }, [])

    return [isSending, deleteTodo]
}