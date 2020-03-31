import { useState, useEffect, useRef } from 'react';
import { useSelector, useDispatch, batch } from 'react-redux';
import {
    getActiveOrderByLikes,
    getActivePage,
    getLastTodoFromPrevPage,
    getVisibilityFilter,
} from '../redux/selectors';
import { addTodos, updateActivePage, updateTotalItemsCount } from '../redux/actions';
import axios from 'axios';

const preparePrevIdAndPrevLikesCount = (prevActivePage) => {
    const activePage = useSelector(getActivePage);
    const { id: prevId, likes_count: prevLikesCount } = useSelector(getLastTodoFromPrevPage) || {};

    if (activePage !== prevActivePage) {
        return {
            prevId: !prevId ? '' : prevId,
            prevLikesCount: !prevLikesCount ? '' : prevLikesCount,
            isReturnToFirstPage: false,
        }
    }

    return { prevId: '', prevLikesCount: '', isReturnToFirstPage: true }
}

export default () => {
    const [isLoading, setIsLoading] = useState(false);
    const activePage = useSelector(getActivePage);
    const visibilityFilter = useSelector(getVisibilityFilter);
    const orderByLikesDirection = useSelector(getActiveOrderByLikes);
    const prevPage = useRef(activePage)
    const dispatch = useDispatch()
    const { prevId, prevLikesCount, isReturnToFirstPage } = preparePrevIdAndPrevLikesCount(prevPage.current)
    const url = `api/todos/?prevId=${prevId}&status=${visibilityFilter}&orderByLikes=${orderByLikesDirection}&prevLikesCount=${prevLikesCount}`;

    useEffect(() => {
        setIsLoading(true);
        axios
            .get(url)
            .then(
                (response) => {
                    if (isReturnToFirstPage) {
                        batch(() => {
                            dispatch(addTodos(response.data.todos, 1, response.data.todosIds))
                            dispatch(updateActivePage(1))
                            dispatch(updateTotalItemsCount(response.data.totalItemsCount[visibilityFilter]));
                        })
                    } else {
                        batch(() => {
                            dispatch(addTodos(response.data.todos, activePage, response.data.todosIds))
                            dispatch(updateTotalItemsCount(response.data.totalItemsCount[visibilityFilter]))
                        })
                    }
                    setIsLoading(false);
                    prevPage.current = activePage
                })
            .catch((error) => {
                setIsLoading(false);
                // todo: create popup for errors
                console.log(error);
            }).finally(
            () => prevPage.current = activePage
        );

    }, [activePage, visibilityFilter, orderByLikesDirection]);

    return isLoading;
}