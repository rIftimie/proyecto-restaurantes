const url = 'http://127.0.0.1:8000/admin/user';

export const getUsers = async () => {

    try {
        const response = await fetch(url);
        const data = await response.json();
        console.log(data);
        return data;
    } catch (error) {
        console.log(error);
    }
    
   
};