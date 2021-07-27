using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class PanelScroll : MonoBehaviour {

    public float speed;
    public Image[] images;
    public Text[] texts;
    [HideInInspector]
    public int aim;
    public InputField[] inputFields;

    string[] keys = { "name", "bio", "address", "phone" };
    int initFont;
    float init;
    RectTransform rectTransform;

	void Start ()
    {
        rectTransform = GetComponent<RectTransform>();
        initFont = texts[0].fontSize;

        SetProfilePlayerPrefs();
	}
	
	public void Scroll (int n)
    {
        aim = n - 1;

        for (int i = 0; i < images.Length; i++)
            if (i == n)
            {
                images[i].enabled = true;
                texts[i].fontStyle = FontStyle.Bold;
                texts[i].fontSize = initFont + 10;
            }
            else
            {
                images[i].enabled = false;
                texts[i].fontStyle = FontStyle.Normal;
                texts[i].fontSize = initFont;
            }
	}

    void SetProfilePlayerPrefs()
    {
        for (int i = 0; i < inputFields.Length; i++)
        {
            string s = PlayerPrefs.GetString(keys[i], "");

            if (s != "")
                inputFields[i].text = s;
        }
    }

    public void UpdateProfilePlayerPrefs()
    {
        for(int i = 0; i < inputFields.Length; i++)
            PlayerPrefs.SetString(keys[i], inputFields[i].text);
    }

    void LateUpdate ()
    {
        float px = Mathf.Lerp(rectTransform.position.x, -aim * Screen.width, speed * Time.deltaTime);
        rectTransform.position = new Vector2(px, rectTransform.position.y);
    }
}
