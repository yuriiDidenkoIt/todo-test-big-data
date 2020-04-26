// todo: get it from the api
export const VISIBILITY_FILTERS_IDS = {
    ALL: 0,
    NEW: 1,
    COMPLETED: 2,
    REJECTED: 3,
    IN_PROGRESS: 4,
}
export const VISIBILITY_FILTERS = {
    [VISIBILITY_FILTERS_IDS.ALL]: "All",
    [VISIBILITY_FILTERS_IDS.NEW]: "New",
    [VISIBILITY_FILTERS_IDS.COMPLETED]: "Completed",
    [VISIBILITY_FILTERS_IDS.REJECTED]: "Rejected",
    [VISIBILITY_FILTERS_IDS.IN_PROGRESS]: "In progress",
};

export const ORDER_BY_LIKES = {
    DESC: "DESC",
    ASC: "ASC",
};
