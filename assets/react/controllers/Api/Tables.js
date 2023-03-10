const url = 'http://localhost:8000/admin/tables';

export const getTables = async () => {

    try {
        const response = await fetch(url);
        const data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
};