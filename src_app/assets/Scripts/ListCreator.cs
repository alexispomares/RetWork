using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using UnityEngine.UI;

public class ListCreator : MonoBehaviour {

    public struct JobOffer
    {
        public string title, description;
        public string[] schedule;
        public int pay;
        public string[] keywords, limitations;
        public string address, phone, company;

        public JobOffer(string _title, string _description, string[] _schedule, int _pay, string[] _keywords, string[] _limitations, string _address, string _phone, string _company)
        {
            title = _title;
            description = _description;
            schedule = _schedule;
            pay = _pay;
            keywords = _keywords;
            limitations = _limitations;
            address = _address;
            phone = _phone;
            company = _company;
        }
    }

    public Transform listGameObject;
    public GameObject buttonPrefab;
    public InputField inputField;
    public TextAsset textAsset;
    public static JobOffer[] jobOffers;

    void Awake ()
    {
        //StartCoroutine(RefreshData());
        ReadData(textAsset.text);

        InitializeChildren();
    }

    void ReadData (string _inputText)
    {
        string wholeText = _inputText;
        
        string[] usersTexts = wholeText.Split("\n" [0]);

        jobOffers = new JobOffer[usersTexts.Length];

        for (int i = 0; i < usersTexts.Length; i++)
        {
            string[] sectionsTexts = usersTexts[i].Split(">" [0]);

            jobOffers[i] = new JobOffer(sectionsTexts[0], sectionsTexts[1], sectionsTexts[2].Split(';'), int.Parse(sectionsTexts[3]), sectionsTexts[4].Split(','), sectionsTexts[5].Split(','), sectionsTexts[6], sectionsTexts[7], sectionsTexts[8]);
        }
    }

    //IEnumerator RefreshData()
    //{
    //    ReadData(textAsset.text);

    //    while (true)
    //    {
    //        WWW www = new WWW("http://xchangeinc.x10host.com/joboffersfile.txt");
    //        yield return www;
    //        if (www.error != null)
    //        {
    //            ReadData(textAsset.text);
    //            break;
    //        }
    //        else
    //        {
    //            ReadData(www.text);
    //            yield return null;
    //            print(www.text);
    //            UpdateList();
    //        }

    //        yield return new WaitForSeconds(10);
    //    }
    //}

    void CleanChildren(Transform t)
    {
        foreach (Transform child in t)
                Destroy(child.gameObject);
    }

    void CreateChildren (bool[] _deleteArray = default(bool[]))
    {
        if (_deleteArray == null)
            _deleteArray = new bool[jobOffers.Length];

        for (int i = 0; i < jobOffers.Length; i++)
        {
            if (!_deleteArray[i])
            {
                var go = Instantiate(buttonPrefab) as GameObject;
                go.transform.SetParent(listGameObject, false);
                go.GetComponent<OnClickJobButton>().identifier = i;

                var texts = go.GetComponentsInChildren<Text>();
                texts[0].text = jobOffers[i].title;
                if (jobOffers[i].pay == 0)
                    texts[1].text = "flex.";
                else
                    texts[1].text = "<b>$</b> " + jobOffers[i].pay;
            }
        }
    }

    void InitializeChildren ()
    {
        CleanChildren(listGameObject);

        CreateChildren();
    }

    public void UpdateList()
    {
        if (inputField.text == "")
            InitializeChildren();
        else
        {
            string[] inputKeywords = inputField.text.Split(' ');
            var deleteArray = new bool[jobOffers.Length];

            for (int i = 0; i < deleteArray.Length; i++)
            {
                foreach (string ikw in inputKeywords)
                {
                    foreach (string kw in jobOffers[i].keywords)
                    {
                        deleteArray[i] = ikw != kw;

                        if (!deleteArray[i])
                            break;
                    }

                    if (!deleteArray[i])
                        break;
                }
            }

            CleanChildren(listGameObject);

            CreateChildren(deleteArray);
        }
    }
}
