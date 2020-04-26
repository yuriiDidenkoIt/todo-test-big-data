import { useState, useEffect, useRef } from 'react';
import { useDispatch, useSelector, batch } from 'react-redux';
import { getActivePage, getActiveFilter } from '../redux/selectors';
import axios from "axios";
import { addTodo, setCountsItemsByFilter, updateTotalItemsCount } from "../redux/actions";
import { VISIBILITY_FILTERS_IDS } from "../constants";

export default () => {
    const [isSending, setIsSending] = useState(false);
    const isMounted = useRef(null);
    const activePage = useSelector(getActivePage);
    const visibilityFilter = useSelector(getActiveFilter);
    const dispatch = useDispatch();

    const createTodo = (title, callbackAfter = null) => {
        const params = new URLSearchParams();
        params.append('title', title);

        axios
            .post(`/api/todos`, params)
            .then((response) => {
                setIsSending(false);
                if (activePage === 1 && [VISIBILITY_FILTERS_IDS.ALL, VISIBILITY_FILTERS_IDS.NEW].includes(visibilityFilter)) {
                    batch(() => {
                        dispatch(addTodo(response.data.todo))
                        dispatch(updateTotalItemsCount(response.data.totalItemsCount[visibilityFilter]))
                        dispatch(setCountsItemsByFilter(response.data.totalItemsCount));
                    })
                }
                if (typeof callbackAfter === 'function') {
                    callbackAfter();
                }
            })
            .catch((error) => {
                console.error(error);
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

    return [isSending, createTodo]
}