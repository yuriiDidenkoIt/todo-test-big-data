import { useState, useEffect, useRef } from 'react';
import {batch, useDispatch, useSelector } from 'react-redux';
import { getActiveOrderByLikes, getActivePage, getLastTodoByActivePage, getVisibilityFilter } from '../redux/selectors';
import axios from 'axios';
import { addTodos, reorderTodos, updateTodo, updateTotalItemsCount } from '../redux/actions';
import { VISIBILITY_FILTERS } from '../constants';

export default () => {
    const [isSending, setIsSending] = useState(false);
    const lastTodo = useSelector(getLastTodoByActivePage);
    const activePage = useSelector(getActivePage);
    const visibilityFilter = useSelector(getVisibilityFilter);
    const orderByLikes = useSelector(getActiveOrderByLikes);
    const dispatch = useDispatch();
    const abortControllerRef = useRef();
    const isMounted = useRef(null);

    const update = (todoId, todoIndex, data, callbackAfter = null) => {
        setIsSending(true);
        abortControllerRef.current = new AbortController();
        const { title, status } = data;
        const params = new URLSearchParams();
        if (title) params.append('title', title);
        if (status) params.append('newStatus', status);
        if (!title && !status) return;

        params.append('prevId', lastTodo.id);
        params.append('prevLikesCount', lastTodo.likes_count);
        params.append('orderByLikes', orderByLikes);
        params.append('status', visibilityFilter === VISIBILITY_FILTERS.ALL ? '' : visibilityFilter);
        params.append('limit', 1);
        params.append('signal', abortControllerRef.current.signal);

        axios.put(`/api/todos/${todoId}`, params)
            .then((response) => {
                setIsSending(false)
                if (!response.data.lastTodo) {
                    batch(() => {
                        dispatch(updateTodo(response.data.todo))
                        dispatch(updateTotalItemsCount(response.data.totalItemsCount[visibilityFilter]))
                    })
                } else {
                    batch(() => {
                        dispatch(reorderTodos(response.data.lastTodo,todoIndex, activePage));
                        dispatch(updateTotalItemsCount(response.data.totalItemsCount[visibilityFilter]))
                    })
                }
                if(typeof callbackAfter === 'function') {
                    callbackAfter();
                }
            })
            .catch((error) => {
                // todo : create popup for error message
                console.log(error);
            }).finally(() => {
            if (isMounted.current) {
                setIsSending(false);
                if(typeof callbackAfter === 'function') {
                    callbackAfter();
                }
            }
        });
    }

    useEffect(() => {
        isMounted.current = true;
        return () => {
            if (abortControllerRef.current) {
                abortControllerRef.current.abort()
            }
            isMounted.current = false;
        };
    }, [])

    return [isSending, update]

}