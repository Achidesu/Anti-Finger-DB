fetch(`https://api.sheetbest.com/sheets/eb063465-9a3d-49c9-9922-76fde01f3c24/${id}`, {
  method: "DELETE",
})
  .then((response) => response.json())
  .then((data) => {
    console.log(data);
  })
  .catch((error) => {
    console.error(error);
  });