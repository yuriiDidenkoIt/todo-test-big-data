import {
    ADD_TODO,
    ADD_TODOS,
    UPDATE_TODO,
    SET_FILTER,
    UPDATE_ACTIVE_PAGE,
    SET_ORDER_BY_LIKES,
    REORDER_TODOS,
    UPDATE_TOTAL_ITEMS_COUNT,
} from './actionTypes';

export const addTodo = (todo) => ({
    type: ADD_TODO,
    payload: {
        todo
    }
});

export const addTodos = (todos, pageId, todosIds) => ({
    type: ADD_TODOS,
    payload: {
        todos,
        pageId,
        todosIds
    }
});

export const updateTodo = todo => ({
    type: UPDATE_TODO,
    payload: { todo }
});

export const setFilter = (filter) => ({
    type: SET_FILTER,
    payload: { filter },
});

export const setOderByLikes = (order) => ({
    type: SET_ORDER_BY_LIKES,
    payload: { order },
});

export const updateActivePage = activePage => ({
    type: UPDATE_ACTIVE_PAGE,
    payload: { activePage },
});

export const updateTotalItemsCount = (totalItemsCount) => ({
    type: UPDATE_TOTAL_ITEMS_COUNT,
    payload: { totalItemsCount },
});

export const reorderTodos = (lastTodo, todoIndex, activePage) => ({
    type: REORDER_TODOS,
    payload: { lastTodo, todoIndex, activePage },
});