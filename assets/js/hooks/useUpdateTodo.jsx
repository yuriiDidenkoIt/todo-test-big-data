import { useState, useEffect, useRef } from 'react';
import {batch, useDispatch, useSelector } from 'react-redux';
import { getActiveOrderByLikes, getActivePage, getActiveFilter } from '../redux/selectors';
import axios from 'axios';
import { reorderTodos, setCountsItemsByFilter, updateTodo, updateTotalItemsCount } from '../redux/actions';
import { VISIBILITY_FILTERS } from '../constants';

export default () => {
    const [isSending, setIsSending] = useState(false);
    const activePage = useSelector(getActivePage);
    const visibilityFilter = useSelector(getActiveFilter);
    const order = useSelector(getActiveOrderByLikes) || '';
    const dispatch = useDispatch();
    const abortControllerRef = useRef();
    const isMounted = useRef(null);

    const update = (todoId, todoIndex, data, callbackAfter = null) => {
        setIsSending(true);
        abortControllerRef.current = new AbortController();
        const { title, statusId } = data;
        const params = new URLSearchParams();
        if (title) params.append('title', title);
        if (statusId) params.append('newStatusId', statusId);
        if (!title && !statusId) return;

        params.append('activePage', activePage);
        params.append('order', order);
        params.append('statusId', visibilityFilter === VISIBILITY_FILTERS.ALL ? '' : visibilityFilter);
        params.append('limit', 1);
        params.append('signal', abortControllerRef.current.signal);

        axios.put(`/api/todos/${todoId}`, params)
            .then((response) => {
                setIsSending(false)
                if (!response.data.lastTodo) {
                    batch(() => {
                        dispatch(updateTodo(response.data.todo))
                        dispatch(updateTotalItemsCount(response.data.totalItemsCount[visibilityFilter]))
                        dispatch(setCountsItemsByFilter(response.data.totalItemsCount));
                    })
                } else {
                    batch(() => {
                        dispatch(reorderTodos(response.data.lastTodo,todoIndex, activePage));
                        dispatch(updateTotalItemsCount(response.data.totalItemsCount[visibilityFilter]))
                        dispatch(setCountsItemsByFilter(response.data.totalItemsCount));
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