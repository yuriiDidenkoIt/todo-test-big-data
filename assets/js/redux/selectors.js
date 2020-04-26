export const getTodosState = (store) => store.todos;

export const getPaginationState = (store) => store.pagination;

export const getActiveOrderByLikes = (store) => store.orderByLikes;
export const getActiveFilter = (store) => store.visibilityFilter.filter;
export const getActivePage = (store) => getPaginationState(store).activePage;

export const getFiltersCounts = (store) => store.visibilityFilter.counts;

export const getTodoListIdsByActivePage = (store) =>
    getTodosState(store) ? getTodosState(store).todosIdsByPageId[getActivePage(store)] : [];

export const getTodoById = (store, id) =>
    getTodosState(store) ? { ...getTodosState(store).byIds[id], id } : null;

export const getTodos = (store) =>
    getTodoListIdsByActivePage(store)
        ? getTodoListIdsByActivePage(store).map((id) => getTodoById(store, id))
        : [];
