import { useState, useEffect } from 'react';
import { useSelector, useDispatch, batch } from 'react-redux';
import {
    getActiveOrderByLikes,
    getActivePage,
    getActiveFilter,
} from '../redux/selectors';
import { addTodos, setCountsItemsByFilter, updateTotalItemsCount } from '../redux/actions';
import axios from 'axios';

export default () => {
    const [isLoading, setIsLoading] = useState(false);
    const activePage = useSelector(getActivePage);
    const visibilityFilter = useSelector(getActiveFilter);
    const order = useSelector(getActiveOrderByLikes) || '';
    const dispatch = useDispatch()
    const url = `api/todos/?activePage=${activePage}&statusId=${visibilityFilter}&order=${order}`;

    useEffect(() => {
        setIsLoading(true);
        axios
            .get(url)
            .then(
                (response) => {
                    batch(() => {
                        dispatch(addTodos(response.data.todos, activePage, response.data.todosIds))
                        dispatch(updateTotalItemsCount(response.data.totalItemsCount[visibilityFilter]))
                        dispatch(setCountsItemsByFilter(response.data.totalItemsCount));
                    })
                    setIsLoading(false);
                })
            .catch((error) => {
                setIsLoading(false);
                // todo: create popup for errors
                console.log(error.message);
            });

    }, [activePage, visibilityFilter, order]);

    return isLoading;
}